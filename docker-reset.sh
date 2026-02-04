#!/bin/bash
# Docker Reset Script untuk Lapas Jombang
# ⚠️ WARNING: This will DELETE all data in Docker volumes!

set -e

# Colors
RED='\033[0;31m'
BLUE='\033[0;34m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m'

echo -e "${RED}================================================${NC}"
echo -e "${RED}  ⚠️  WARNING: Docker Reset${NC}"
echo -e "${RED}================================================${NC}"
echo -e "${YELLOW}This will:${NC}"
echo -e "${YELLOW}  1. Stop all containers${NC}"
echo -e "${YELLOW}  2. Remove all containers${NC}"
echo -e "${YELLOW}  3. Remove all volumes (DATABASE WILL BE DELETED!)${NC}"
echo -e "${YELLOW}  4. Remove all networks${NC}"
echo ""
read -p "Are you SURE you want to continue? (type 'yes' to confirm): " CONFIRM

if [ "$CONFIRM" != "yes" ]; then
    echo -e "${GREEN}❌ Reset cancelled.${NC}"
    exit 0
fi

echo -e "${BLUE}🧹 Stopping and removing containers...${NC}"
docker compose -f docker-compose.dev.yml down -v 2>/dev/null || true
docker compose down -v 2>/dev/null || true

echo -e "${BLUE}🗑️  Removing orphaned containers...${NC}"
docker compose -f docker-compose.dev.yml down --remove-orphans 2>/dev/null || true

echo -e "${BLUE}🧼 Pruning Docker system...${NC}"
docker system prune -f

echo -e "${GREEN}✅ Docker reset complete!${NC}"
echo -e "${YELLOW}Run './docker-start.sh' to start fresh.${NC}"
