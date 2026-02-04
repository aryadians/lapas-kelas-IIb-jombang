#!/bin/bash
# Docker Start Script untuk Lapas Jombang
# Usage: ./docker-start.sh [dev|prod]

set -e

# Determine environment
ENV=${1:-dev}

# Colors for output
GREEN='\033[0;32m'
BLUE='\033[0;34m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

echo -e "${BLUE}================================================${NC}"
echo -e "${BLUE}  🚀 Lapas Jombang - Docker Startup${NC}"
echo -e "${BLUE}  Environment: ${YELLOW}${ENV}${NC}"
echo -e "${BLUE}================================================${NC}"

# Check if Docker is running
if ! docker info > /dev/null 2>&1; then
    echo -e "${YELLOW}⚠️  Docker is not running. Please start Docker Desktop.${NC}"
    exit 1
fi

# Check if .env exists
if [ ! -f .env ]; then
    echo -e "${YELLOW}📝 Creating .env file from .env.example...${NC}"
    cp .env.example .env
    echo -e "${GREEN}✅ .env file created. Please review and update if needed.${NC}"
fi

# Start appropriate environment
if [ "$ENV" = "prod" ]; then
    echo -e "${GREEN}🏭 Starting PRODUCTION environment...${NC}"
    docker compose up -d --build
    
    echo ""
    echo -e "${GREEN}✅ Production environment started!${NC}"
    echo -e "${BLUE}================================================${NC}"
    echo -e "${GREEN}📱 Application:${NC}  http://localhost"
    echo -e "${BLUE}================================================${NC}"
else
    echo -e "${GREEN}💻 Starting DEVELOPMENT environment...${NC}"
    
    # Check if node_modules exists
    if [ ! -d "node_modules" ]; then
        echo -e "${YELLOW}📦 Installing Node.js dependencies...${NC}"
        docker run --rm -v "$(pwd):/app" -w /app node:20-alpine npm install
    fi
    
    # Check if vendor exists
    if [ ! -d "vendor" ]; then
        echo -e "${YELLOW}📦 Installing Composer dependencies...${NC}"
        docker run --rm -v "$(pwd):/app" -w /app composer:2.7 install
    fi
    
    docker compose -f docker-compose.dev.yml up -d --build
    
    echo ""
    echo -e "${GREEN}✅ Development environment started!${NC}"
    echo -e "${BLUE}================================================${NC}"
    echo -e "${GREEN}📱 Application:${NC}    http://localhost:8080"
    echo -e "${GREEN}📧 Mailpit:${NC}        http://localhost:8025"
    echo -e "${GREEN}🔥 Vite HMR:${NC}       http://localhost:5173"
    echo -e "${GREEN}🗄️  MySQL:${NC}         localhost:3306"
    echo -e "${GREEN}💾 Redis:${NC}          localhost:6379"
    echo -e "${BLUE}================================================${NC}"
fi

# Show logs
echo ""
echo -e "${YELLOW}📋 Showing logs (Ctrl+C to exit, containers will keep running)${NC}"
echo -e "${BLUE}================================================${NC}"

if [ "$ENV" = "prod" ]; then
    docker compose logs -f
else
    docker compose -f docker-compose.dev.yml logs -f
fi
