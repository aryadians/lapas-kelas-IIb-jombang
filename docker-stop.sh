#!/bin/bash
# Docker Stop Script untuk Lapas Jombang

set -e

# Colors
BLUE='\033[0;34m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m'

echo -e "${BLUE}================================================${NC}"
echo -e "${BLUE}  🛑 Stopping Lapas Jombang Containers${NC}"
echo -e "${BLUE}================================================${NC}"

# Stop development containers
if docker compose -f docker-compose.dev.yml ps -q 2>/dev/null | grep -q .; then
    echo -e "${YELLOW}Stopping development containers...${NC}"
    docker compose -f docker-compose.dev.yml down
fi

# Stop production containers
if docker compose ps -q 2>/dev/null | grep -q .; then
    echo -e "${YELLOW}Stopping production containers...${NC}"
    docker compose down
fi

echo -e "${GREEN}✅ All containers stopped successfully!${NC}"
