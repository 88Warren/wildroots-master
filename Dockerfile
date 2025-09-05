# Use an official Nginx image as the base image
FROM nginx:alpine

# Remove the default Nginx configuration
RUN rm /etc/nginx/conf.d/default.conf

# Copy our custom Nginx configuration file
COPY nginx.conf /etc/nginx/conf.d/

# Set the working directory (optional but good practice)
WORKDIR /var/www/html

# Expose port 80
EXPOSE 80