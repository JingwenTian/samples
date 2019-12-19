--[[
    @desc
    author: JingwenTian
    time: 2019-06-07 13:45:56
]]

local account = require("account")

local a = account:new()
a:add(100)
a:sub(50)

local b = account:new()
b:add(50)

print(a.balance)  --> output: 100
print(b.balance)  --> output: 50


local st = require("s_more")

print(st.upper('aaaaa'), st.lower('BBBBBB'))

------------------------
-- 成员私有性
------------------------
local function newAccount(initialBalance)
    local self = {balance = initialBalance or 0}

    local add = function(v)
        self.balance = self.balance + v
    end

    local sub = function(v)
        self.balance = self.balance - v
    end

    local getBalance = function() return self.balance end

    return {
        add = add,
        sub = sub,
        getBalance = getBalance
    }
end

local ac = newAccount(100)
ac.add(55)
ac.sub(10)
print(ac.getBalance())
print(ac.balance)