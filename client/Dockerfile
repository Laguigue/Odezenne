FROM node:latest

MAINTAINER Bram van Osta <bramvanosta@gmail.com>

RUN apt-get update && apt-get install -y bzip2 libfontconfig

ENV PHANTOMJS_BIN "/usr/local/bin/phantomjs"
RUN yarn global add phantomjs-prebuilt node-sass
