FROM node:20

WORKDIR /app
EXPOSE 3000

COPY package-lock.json package.json ./
RUN npm install
COPY . . 

HEALTHCHECK CMD curl -f http://localhost:3000/ || exit 1

ENTRYPOINT npm run start