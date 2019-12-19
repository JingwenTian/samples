--[[
    @desc
    author: JingwenTian
    time: 2019-06-07 14:20:52
]]

local tb = {1, 2, 3, 4, 5}
print(#tb)
print(#(tb))
print(table.getn(tb))

-- 不要在 Lua 的 table 中使用 nil 值，如果一个元素要删除，直接 remove，不要用 nil 去代替
local tb2 = {1, nil, 3}
print(#tb2) -- 1

local tb3 = {2, 3, 4}
table.remove( tb3, 1 )
print(table.concat( tb3, ", " )) --3, 4


