--[[
    @desc
    author: JingwenTian
    time: 2019-06-04 17:47:03
]]
-----------------------------
-- 热装载代码
-----------------------------
local user_script =
    [[
    local num = 0
    local rand = math.random
    for i = 1, 200 do
        num = num + rand(i)
    end
    ngx.say("res:", num)
]]

local function handle_timeout(typ)
    return error("user script too hot")
end

local function handle_error(err)
    return string.format("%s: %s", err or "", debug.traceback())
end

-- disable JIT in the user script to ensure debug hooks always work:
user_script = [[jit.off(true, true) ]] .. user_script

local f, err = loadstring(user_script, "=user script")
if not f then
    ngx.say("ERROR: failed to load user script: ", err)
    return
end

-- only enable math.*, and ngx.say in our sandbox:
local env = {
    math = math,
    ngx = {say = ngx.say},
    jit = {off = jit.off}
}
setfenv(f, env)

local instruction_limit = 2000
debug.sethook(handle_timeout, "", instruction_limit)
local ok, err = xpcall(f, handle_error)
if not ok then
    ngx.say("failed to run user script: ", err)
end
debug.sethook() -- turn off the hooks


-----------------------------
-- OpenResty 的缓存: Lua shared dict
-- https://github.com/openresty/lua-nginx-module#ngxshareddict
-----------------------------
local function get_cache(key)
    local cache = ngx.shared.my_cache
    local value = cache:get(key)
    return value
end

local function set_cache(key, value, expires)
    if not expires then
        expires = 0
    end

    local cache = ngx.shared.my_cache
    local succ, err, forcible = cache:set(key, value, expires)
    return succ
end

set_cache("name", "jingwentian", 1000)
ngx.say("cache val:", get_cache("name"))


-- ngx.shared.DICT 非队列性质
-- 使用 FIFO 规则的队列时, 最好使用 Redis 的队列
ngx.shared.my_cache:lpush("queue", "this is a message1")
ngx.shared.my_cache:lpush("queue", "this is a message2")
ngx.shared.my_cache:lpush("queue", "this is a message3")
ngx.shared.my_cache:lpush("queue", "this is a message4")
ngx.shared.my_cache:lpush("queue", "this is a message5")
ngx.shared.my_cache:lpush("queue", "this is a message6")
ngx.shared.my_cache:lpush("queue", "this is a message7")
ngx.shared.my_cache:lpush("queue", "this is a message8")

while true do
    local res = ngx.shared.my_cache:rpop("queue")
    if nil == res then
        break
    end
    ngx.say("queue val:", res)
end 
ngx.say("queue done!")

-----------------------------
-- 定时任务
-- https://moonbingbing.gitbooks.io/openresty-best-practices/content/ngx_lua/timer.html
-----------------------------

local handler = function()
    ngx.log(ngx.ERR, 'timer - ' .. ngx.localtime())
end

local ok, err = ngx.timer.every(5, handler)
if not ok then
    ngx.log(ngx.ERR, "failed to create the timer: ", err)
    return
end


-----------------------------
-- 请求返回后继续执行
-- https://moonbingbing.gitbooks.io/openresty-best-practices/content/ngx_lua/continue_after_eof.html
-----------------------------
local cjson = require "cjson"
local resp = {
    status = 200,
    message = "sucess",
    data = {username = "jingwentian"}
}
ngx.say(cjson.encode(resp))
ngx.eof()

ngx.log(ngx.INFO, 'eof after.....')