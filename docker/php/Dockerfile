FROM php:8.2-fpm-alpine

ARG USER_ID

RUN apk add --no-cache \
    postgresql-dev \
    libzip-dev \
    icu-dev \
    git \
    unzip \
    nano \
    zsh \
    curl \
    zsh-autosuggestions \
    zsh-syntax-highlighting \
    make

RUN docker-php-ext-install pdo pdo_pgsql intl zip opcache

COPY --from=composer:2.6.6 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

RUN if [[ -n "$USER_ID" ]]; then deluser www-data \
    && addgroup -S -g 1000 www-data \
    && adduser -D -g '' -S -h /home/www-data -G www-data -u $USER_ID www-data; \
    fi;

RUN chown -R www-data:www-data /var/www

USER www-data

RUN RUNZSH=no CHSH=no sh -c "$(curl -fsSL https://raw.githubusercontent.com/ohmyzsh/ohmyzsh/master/tools/install.sh)"
RUN echo "source /usr/share/zsh/plugins/zsh-syntax-highlighting/zsh-syntax-highlighting.zsh" >> /home/www-data/.zshrc
RUN echo "source /usr/share/zsh/plugins/zsh-autosuggestions/zsh-autosuggestions.zsh" >> /home/www-data/.zshrc
RUN git config --global --add safe.directory /var/www