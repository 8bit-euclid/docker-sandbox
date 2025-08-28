FROM mcr.microsoft.com/devcontainers/base:ubuntu-22.04

# Install system dependencies
RUN apt-get update && apt-get install -y \
    curl \
    wget \
    unzip \
    zip \
    tree \
    jq \
    build-essential \
    postgresql-client \
    mysql-client \
    redis-tools \
    python3 \
    python3-pip \
    python3-dev \
    python3-venv \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Install Node.js
RUN curl -fsSL https://deb.nodesource.com/setup_lts.x | bash - \
    && apt-get update \
    && apt-get install -y nodejs \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Install Docker CLI (Docker daemon will be accessed via socket mount)
RUN curl -fsSL https://get.docker.com | sh

# Install Docker Compose
RUN curl -L "https://github.com/docker/compose/releases/latest/download/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose \
    && chmod +x /usr/local/bin/docker-compose

# Install kubectl
RUN curl -LO "https://dl.k8s.io/release/$(curl -L -s https://dl.k8s.io/release/stable.txt)/bin/linux/amd64/kubectl" \
    && chmod +x kubectl \
    && mv kubectl /usr/local/bin/

# Install AWS CLI
RUN curl "https://awscli.amazonaws.com/awscli-exe-linux-x86_64.zip" -o "awscliv2.zip" \
    && unzip awscliv2.zip \
    && ./aws/install \
    && rm -rf aws awscliv2.zip

# Add vscode user to docker group (user already exists in base image)
RUN usermod -aG docker vscode

# Install Python development tools
RUN pip3 install \
    black \
    flake8 \
    pytest \
    pytest-asyncio \
    httpx \
    python-dotenv \
    fastapi \
    uvicorn

# Install global Node.js development tools
RUN npm install -g \
    typescript \
    ts-node \
    nodemon \
    eslint \
    prettier \
    yarn

# Switch to vscode user
USER vscode

# Set up useful aliases for vscode user
RUN echo 'alias d="docker"' >> ~/.bashrc \
    && echo 'alias dc="docker-compose"' >> ~/.bashrc \
    && echo 'alias k="kubectl"' >> ~/.bashrc \
    && echo 'alias py="python3"' >> ~/.bashrc

# Set working directory
WORKDIR /workspaces
