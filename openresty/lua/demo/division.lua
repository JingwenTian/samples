-- 除法
local args = ngx.args.get_url_args()
ngx.say(args.a / args.b)