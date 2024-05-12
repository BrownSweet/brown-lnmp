ARG NODE_VERSION
FROM ${NODE_VERSION}

ARG CONTAINER_PACKAGE_URL=mirrors.ustc.edu.cn

#RUN if [ $CONTAINER_PACKAGE_URL ] ; then sed -i "s/dl-cdn.alpinelinux.org/${CONTAINER_PACKAGE_URL}/g" /etc/apk/repositories ; fi
RUN echo "http://mirrors.ustc.edu.cn/alpine/v3.15/main" > /etc/apk/repositories
RUN echo "http://mirrors.ustc.edu.cn/alpine/v3.15/community" >> /etc/apk/repositories

# 设置时区为Asia/Shanghai
ENV TZ=Asia/Shanghai

# 更新时区
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone


RUN npm config set registry https://registry.npmmirror.com
#RUN npm config set registry http://r.cnpmjs.org/
RUN npm install -g cnpm --registry=https://registry.npmmirror.com

RUN npm i pm2 -g

RUN npm i pnpm -g
RUN pnpm config set registry https://registry.npmmirror.com

WORKDIR /var/www
