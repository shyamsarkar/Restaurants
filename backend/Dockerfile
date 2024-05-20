FROM ruby:3.3.0

RUN apt update -qq && apt-get install -y build-essential libpq-dev

WORKDIR /backend

COPY Gemfile Gemfile.lock ./

RUN bundle install

USER root

COPY . .

EXPOSE 5000

# CMD ["rails", "server", "-b", "0.0.0.0", "-p", "5000"]