--[[
    元表
    https://moonbingbing.gitbooks.io/openresty-best-practices/content/lua/metatable.html
    author: JingwenTian
    time: 2019-06-07 12:49:23
]]

---------------------------------------------------- 
-- 元表（metatable） 和元方法（metamethod）。 
---------------------------------------------------- 

local arr1 = {10, 30, 60}
local arr2 = {10, 30, 50}

local merge = function(self, arr)
    local set = {}
    for _, v in pairs(self) do set[v] = true end
    for _, v in pairs(arr) do set[v] = true end
    local result = {}
    for k, _ in pairs(set) do table.insert( result, k ) end
    return result
end

setmetatable(arr1, {__add = merge})

local arr3 = arr1 + arr2
for _, v in pairs(arr3) do
    io.write(v .. " ")
end

-- __index 元方法
local mytable = setmetatable({key1 = 'kkkk1'}, {
    __index = function(self, key)
        if key == 'key2' then
            return 'kkkk2'
        end
    end
})
print(mytable.key1, mytable.key2)

-- __tostring 元方法
local arr4 = {1, 2, 3, 4, 5}
setmetatable(arr4, {__tostring=function(self)
    local str = '{'
    for k, v in pairs(self) do
        str = str .. v 
        if k ~= #self then
            str = str  .. ', '
        end
    end
    str = str .. '}'
    return str
end})
print(arr4)

-- __call 元方法
local func = {}
setmetatable(func, {__call = function(self, arg) 
    print("called from " .. arg)
end})
func("func")

-- __metatable 元方法
obj = setmetatable({}, {__metatable = "You cannot access here"})
print(getmetatable(obj))