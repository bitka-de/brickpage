#!/bin/bash

# Skript zum Setzen des Development-Modus
# Verwendung: ./scripts/set-dev-mode.sh

CONFIG_FILE="app/config/app.php"
BACKUP_FILE="app/config/app.php.backup"

# Farben für Output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

echo -e "${BLUE}🔧 Brickpage Development Mode Setup${NC}"
echo "======================================"

# Prüfen ob config file existiert
if [ ! -f "$CONFIG_FILE" ]; then
    echo -e "${RED}❌ Error: $CONFIG_FILE nicht gefunden!${NC}"
    exit 1
fi

# Backup erstellen
echo -e "${YELLOW}📋 Erstelle Backup...${NC}"
cp "$CONFIG_FILE" "$BACKUP_FILE"

# Development-Einstellungen setzen
echo -e "${BLUE}⚙️  Setze Development-Konfiguration...${NC}"

# sed commands für macOS und Linux kompatibel
if [[ "$OSTYPE" == "darwin"* ]]; then
    # macOS
    sed -i '' "s/'env' => 'production'/'env' => 'development'/g" "$CONFIG_FILE"
    sed -i '' "s/'debug' => false/'debug' => true/g" "$CONFIG_FILE"
    sed -i '' "s/'dev_mode' => false/'dev_mode' => true/g" "$CONFIG_FILE"
else
    # Linux
    sed -i "s/'env' => 'production'/'env' => 'development'/g" "$CONFIG_FILE"
    sed -i "s/'debug' => false/'debug' => true/g" "$CONFIG_FILE"
    sed -i "s/'dev_mode' => false/'dev_mode' => true/g" "$CONFIG_FILE"
fi

echo -e "${GREEN}✅ Development-Modus aktiviert!${NC}"
echo ""
echo -e "${BLUE}📊 Aktuelle Einstellungen:${NC}"
echo -e "   • Environment: ${YELLOW}development${NC}"
echo -e "   • Debug: ${YELLOW}true${NC}"
echo -e "   • Dev Mode: ${YELLOW}true${NC}"
echo ""
echo -e "${GREEN}🚀 Vite Dev Server wird gestartet...${NC}"