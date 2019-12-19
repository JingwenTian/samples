--[[
    面向对象编程
    https://moonbingbing.gitbooks.io/openresty-best-practices/content/lua/object_oriented.html
    author: JingwenTian
    time: 2019-06-07 12:49:23
]]

------------------------
-- 类
------------------------
local _M = {}

local mt = { __index = _M }

function _M.add (self, v)
    self.balance = self.balance + v
end

function _M.sub (self, v)
    if self.balance > v then
        self.balance = self.balance - v
    else
        error("insufficient funds")
    end
end

function _M.new (self, balance)
    balance = balance or 0
    return setmetatable({balance = balance}, mt)
end

return _M
