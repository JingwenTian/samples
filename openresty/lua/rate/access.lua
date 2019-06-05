--[[
    @desc
    author: JingwenTian
    time: 2019-06-04 20:36:57
]]

local limit_conn = require "lib.utils.limit_conn"

-- 对于内部重定向或子请求，不进行限制。因为这些并不是真正对外的请求。
if ngx.req.is_internal() then
    return
end

limit_conn.incoming()