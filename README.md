# ChatPHP

天津理工大学 网站设计与维护 2023 课设

使用 Docker Compose 启动，镜像由本仓库的 workflow 构建。

```yaml
version: '2'
services:
  web:
    image: rockchin/chatphp-prod:latest
    container_name: chatphp-prod
    volumes:
      - ./:/app/public/
    environment:
      - TZ=Asia/Shanghai
      - OPENAI_API_KEY=<your openai api key>
      - MYSQL_HOST=127.0.0.1
      - MYSQL_USER=root
      - MYSQL_PASSWORD=abc123
      - MYSQL_DATABASE=app
    ports:
      - "80:80"
      - "13306:3306"
```