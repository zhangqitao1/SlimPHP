# SlimPHP
a small php framework


# Nginx conf
server {
        listen       80;
        server_name slim.dev;
        root /Users/og/Documents/wwwroot/slim-php/web;

         location / {
                # try to serve file directly, fallback to front controller
                try_files $uri /index.php$is_args$args;
        }

        location ~ \.php$ {
            fastcgi_pass   127.0.0.1:9000;
            fastcgi_index  index.php;
            fastcgi_param  SCRIPT_FILENAME  $document_root$fastcgi_script_name;
            include        fastcgi_params;
        }
}

# step
