--[[
    @desc
    author: JingwenTian
    time: 2019-06-04 11:57:30
]]

local redis = require "resty.redis"
local red = redis:new()

red:set_timeout(1000)

-- 建立连接
local ok, err = red:connect("127.0.0.1", 6379)
if not ok then 
    ngx.say("failed to connect: ", err)
    return
end

-- 有密码的话需要鉴权
-- local count
-- count, err = red:get_reused_times()
-- if 0 == count then 
--     ok, err = red:auth("tjw199022")
--     if not ok then
--         ngx.say("failed to auth: ", err)
--         return 
--     end 
-- elseif err then 
--     ngx.say("failed to get reused times:", err)
--     return
-- end 

-- 选择库号
ok, err = red:select(1)
if not ok then
    ngx.say("failed to select db: ", err)
    return
end

-- 设置缓存
ok, err = red:set("dog", "an animal")
if not ok then 
    ngx.say("failed to set dog:", err)
    return
end
ngx.say("set result: ", ok)

-- 获取缓存
local res, err = red:get("dog")
if not res then
    ngx.say("failed to get dog:", err)
    return
end 
ngx.say("get result:", res)


-- 如果选择了库号, 那使用后再重置库号, 
-- 避免select + set_keepalive 组合操作引起的数据读写错误
ok, err = red:select(0)
if not ok then
    ngx.say("failed to select db: ", err)
    return
end

-- 连接池设置
-- 连接池大小是100个，并且设置最大的空闲时间是 10 秒
local ok, err = red:set_keepalive(10000, 100)
if not ok then 
    ngx.say("failed to set keepalive:", err)
    return
end 

--------------------------------
-- 使用封装的 redis_iresty 进行调用
--------------------------------

local iresty = require "lib.resty.redis_iresty"
local irestyc = iresty:new() 

local ok, err = irestyc:set("name", "china")
if not ok then 
    ngx.say("failed to set name: ", err)
    return 
end 
local res, err = irestyc:get("name")
if not res then 
    ngx.say("failed to get name:", err)
    return 
end 
ngx.say("get result:", res)
