--[[
    @desc
    author: JingwenTian
    time: 2019-06-07 14:02:11
]]

------------------------
-- 继承
------------------------
local s_base = require("s_base")

local _M = {}
_M = setmetatable(_M, {__index = s_base})

function _M.lower(str)
    return string.lower(str)
end

return _M
