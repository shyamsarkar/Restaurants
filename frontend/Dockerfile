FROM node:21.7.3

WORKDIR /frontend

COPY package*.json ./

RUN npm install

COPY . .

EXPOSE 8000

# CMD ["npm", "start"]