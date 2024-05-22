# FROM node:20 as dev-stage
# WORKDIR /app
# COPY package*.json ./
# RUN npm install
# COPY ./ .
# 
# EXPOSE 5173
# 
# CMD [ "npm", "run", "dev"]

FROM node:20 as build-stage
WORKDIR /app
COPY package*.json ./
RUN npm install
COPY ./ .
RUN npm run build

FROM nginx as production-stage
EXPOSE 3000
# RUN mkdir /app
COPY nginx.conf /etc/nginx/conf.d/default.conf
# COPY --from=build-stage /app/dist/ /app
COPY --from=build-stage /app/dist/ /usr/share/nginx/html