--[[
    @desc
    author: JingwenTian
    time: 2019-06-04 19:33:15
]]
local _M = {}

local ips = {
    --[["127.0.0.1",]]
    "10.10.10.0/24",
    "192.168.0.0/16"
}

function _M.get_ips()
    return ips
end

return _M
