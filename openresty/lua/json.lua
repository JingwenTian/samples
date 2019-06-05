--[[
    @desc
    author: JingwenTian
    time: 2019-06-04 13:45:26
]]
----------------------------------
-- json 解析的异常捕获
----------------------------------
-- local str = [[ {"key": "value"} ]]

-- json decode 失败异常
--local json = require "cjson"
-- local res = json.decode(str)
-- ngx.say("--->", type(res))

-- 改良的 json_decode
-- local decode = require("cjson").decode
-- function json_decode( str )
--     local ok, t = pcall(decode, str)
--     if not ok then
--       return nil
--     end
--     return t
-- end
-- ngx.say("--->", type(json_decode(str)))

-- CJSON 2.1.0，该版本新增一个 cjson.safe 模块接口，该接口兼容 cjson 模块，并且在解析错误时不抛出异常，而是返回 nil
-- local json = require("cjson.safe")
-- local t = json.decode(str)
-- if t then
--     ngx.say("--->", type(t))
-- end

----------------------------------
-- 稀疏数组
----------------------------------
local json = require "cjson"
local data = {1, 2}
data[1000] = 99

-- nginx error: Cannot serialise table: excessively sparse array
-- 如果把 data 的数组下标修改成 5 ，那么这个 json.encode 就会是成功的
-- 为什么下标是 1000 就失败呢？实际上这么做是 cjson 想保护你的内存资源。她担心这个下标过大直接撑爆内存
-- ngx.say(json.encode(data))

-- json.encode_sparse_array(true)
-- ngx.say(json.encode(data))

----------------------------------
-- 编码为 array 还是 object
----------------------------------
local empty = {dogs = {}}
-- ngx.say("value --> ", json.encode(empty))

-- TEST 1: empty tables as objects
print(json.encode(empty))
print(json.encode({}))

-- TEST 2: empty tables as arrays
json.encode_empty_table_as_object(false)
print(json.encode({}))
print(json.encode(empty))

-- 封装一个 json_encode 的示例函数
local function json_encode(data, empty_table_as_object)
    --Lua的数据类型里面，array和dict是同一个东西。对应到json encode的时候，就会有不同的判断
    --cjson对于空的table，就会被处理为object，也就是{}
    --处理方法：对于cjson，使用encode_empty_table_as_object这个方法。
    local cjson = require "cjson"
    cjson.encode_empty_table_as_object(empty_table_as_object or false)
    local ok, json_value = pcall(cjson.encode, data)
    if not ok then
        return nil
    end
    return json_value
end
ngx.say(json_encode(empty, true))
