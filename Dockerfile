# Application image
#
# This image mainly adds the latest application source to the base image
#
FROM myproject/myapp:base-1.0

# Copy PHP configuration into the image
COPY ./config/php/productive.ini /etc/php7/conf.d/90-productive.ini

# Copy the app code into the image
COPY . /var/www/html

# Create required directories listed in .dockerignore
RUN mkdir -p runtime web/assets var/sessions \
    && chown www-data:www-data runtime web/assets var/sessions
