# nginx 配置前后端分离

```nginx
server
    {
        listen 80;
        server_name _ ;
        index index.html index.php;

        set $front_root_path '/home/wwwroot/www/client/dist';
        set $back_root_path '/home/wwwroot/www/api.com/public';

        root $front_root_path;

        location / {
            access_log  /home/wwwlogs/client.www.com.log;
            try_files $uri $uri/ /index.html;
        }

        location ~ /api {
            root $back_root_path;
            try_files $uri $uri/ /index.php?$query_string;
            access_log /home/wwwlogs/api.www.com.log;
            proxy_set_header Host $host;
            proxy_set_header X-Real-IP $remote_addr;
            proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
            proxy_set_header X-Real-Port $remote_port;
        }

        location ~ [^/]\.php(/|$) {
            root $back_root_path;
            try_files $uri =404;
            fastcgi_pass  unix:/tmp/php-cgi.sock;
            fastcgi_index index.php;
            include fastcgi.conf;
        }

        location ~ .*\.(gif|jpg|jpeg|png|bmp|swf)$
        {
            expires      30d;
        }

        location ~ .*\.(js|css)?$
        {
            expires      12h;
        }

        location ~ /.well-known {
            allow all;
        }

        location ~ /\.
        {
            deny all;
        }
    }
```
