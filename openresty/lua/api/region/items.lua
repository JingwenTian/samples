--[[
    @desc
    author: JingwenTian
    time: 2019-06-04 11:57:30
]]

-- https://moonbingbing.gitbooks.io/openresty-best-practices/content/openresty/inline_var.html
-- https://nginx.org/en/docs/varindex.html
-- https://github.com/openresty/lua-nginx-module#ngxvarvariable

local ngx_req = ngx.req
local ngx_var = ngx.var
local cjson = require "cjson"

ngx_req.read_body();

local req = {
    ngx_req = {
        is_internal = ngx_req.is_internal(),
        start_time = ngx_req.start_time(),
        http_version = ngx_req.http_version(),
        raw_header = ngx_req.raw_header(),
        get_method = ngx_req.get_method(),
        get_uri_args = ngx_req.get_uri_args(),
        get_post_args = ngx_req.get_post_args(),
        get_headers = ngx_req.get_headers(),
        get_body_data = ngx_req.get_body_data(),
        get_body_file = ngx_req.get_body_file(),
    },
    ngx_var = {
        arg_name = ngx_var.arg_name,
        args = ngx_var.args,
        body_bytes_sent = ngx_var.body_bytes_sent,
        content_length = ngx_var.content_length,
        content_type = ngx_var.content_type,
        document_root = ngx_var.document_root,
        document_uri = ngx_var.document_uri,
        host = ngx_var.host,
        hostname = ngx_var.hostname,
        http_cookie = ngx_var.http_cookie,
        http_referer = ngx_var.http_referer,
        http_user_agent = ngx_var.http_user_agent,
        http_x_forwarded_for = ngx_var.http_x_forwarded_for,
        is_args = ngx_var.is_args,
        query_string = ngx_var.query_string,
        remote_addr = ngx_var.remote_addr,
        remote_port = ngx_var.remote_port,
        request_method = ngx_var.request_method,
        scheme = ngx_var.scheme,
        server_addr = ngx_var.server_addr,
        server_name = ngx_var.server_name,
        server_port = ngx_var.server_port,
        server_protocol = ngx_var.server_protocol,
        uri = ngx_var.uri,
    }
}

ngx.say(cjson.encode(req))