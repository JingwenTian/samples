--[[
    @desc
    author: JingwenTian
    time: 2019-06-07 13:59:51
]]

local _M = {}

local mt = {__index = _M}

function _M.upper( str )
    return string.upper(str)
end

return _M