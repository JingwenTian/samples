local _M = {}

-- 对输入参数逐个进行校验，只要有一个不是数字类型，则返回 false
function _M.is_number(...)
    local args = {...}

    local num
    for _,v in ipairs(args) do
        num = tonumber(v)
        if nil == num then
            return false
        end
    end
    return true
end

return _M