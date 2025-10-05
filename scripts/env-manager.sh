#!/bin/bash

# Brickpage Environment Manager
# Verwendung: ./scripts/env-manager.sh [dev|prod|status|restore]

CONFIG_FILE="app/config/app.php"
BACKUP_FILE="app/config/app.php.backup"

# Farben für Output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
PURPLE='\033[0;35m'
CYAN='\033[0;36m'
NC='\033[0m' # No Color

# Banner
show_banner() {
    echo -e "${PURPLE}"
    echo "╔══════════════════════════════════════╗"
    echo "║        🧱 Brickpage ENV Manager      ║"
    echo "║              Version 1.0             ║"
    echo "╚══════════════════════════════════════╝"
    echo -e "${NC}"
}

# Hilfsfunktion zum Setzen der Konfiguration
set_config() {
    local env=$1
    local debug=$2
    local dev_mode=$3
    
    if [[ "$OSTYPE" == "darwin"* ]]; then
        # macOS
        sed -i '' "s/'env' => '[^']*'/'env' => '$env'/g" "$CONFIG_FILE"
        sed -i '' "s/'debug' => [^,]*/'debug' => $debug/g" "$CONFIG_FILE"
        sed -i '' "s/'dev_mode' => [^,]*/'dev_mode' => $dev_mode/g" "$CONFIG_FILE"
    else
        # Linux
        sed -i "s/'env' => '[^']*'/'env' => '$env'/g" "$CONFIG_FILE"
        sed -i "s/'debug' => [^,]*/'debug' => $debug/g" "$CONFIG_FILE"
        sed -i "s/'dev_mode' => [^,]*/'dev_mode' => $dev_mode/g" "$CONFIG_FILE"
    fi
}

# Status anzeigen
show_status() {
    echo -e "${BLUE}📊 Aktuelle Konfiguration:${NC}"
    echo "=========================="
    
    if [ -f "$CONFIG_FILE" ]; then
        local env=$(grep "'env'" "$CONFIG_FILE" | head -1 | sed "s/.*'env' => '\([^']*\)'.*/\1/")
        local debug=$(grep "'debug'" "$CONFIG_FILE" | head -1 | sed "s/.*'debug' => \([^,]*\).*/\1/" | tr -d ' ')
        local dev_mode=$(grep "'dev_mode'" "$CONFIG_FILE" | head -1 | sed "s/.*'dev_mode' => \([^,]*\).*/\1/" | tr -d ' ')
        
        echo -e "Environment: ${YELLOW}$env${NC}"
        echo -e "Debug Mode:  ${YELLOW}$debug${NC}"
        echo -e "Dev Mode:    ${YELLOW}$dev_mode${NC}"
        
        if [ "$env" = "development" ]; then
            echo -e "Status:      ${GREEN}🔧 Development${NC}"
        else
            echo -e "Status:      ${BLUE}🏗️  Production${NC}"
        fi
    else
        echo -e "${RED}❌ Konfigurationsdatei nicht gefunden!${NC}"
    fi
    echo ""
}

# Hilfsfunktion anzeigen
show_help() {
    echo -e "${CYAN}📖 Verwendung:${NC}"
    echo "=============="
    echo "  ./scripts/env-manager.sh [Befehl]"
    echo ""
    echo -e "${CYAN}Verfügbare Befehle:${NC}"
    echo "  ${YELLOW}dev${NC}      - Development-Modus aktivieren"
    echo "  ${YELLOW}prod${NC}     - Production-Modus aktivieren"
    echo "  ${YELLOW}status${NC}   - Aktuelle Konfiguration anzeigen"
    echo "  ${YELLOW}restore${NC}  - Backup wiederherstellen"
    echo "  ${YELLOW}help${NC}     - Diese Hilfe anzeigen"
    echo ""
    echo -e "${CYAN}NPM Scripts:${NC}"
    echo "  ${YELLOW}npm run dev${NC}        - Development + Vite Server"
    echo "  ${YELLOW}npm run build${NC}      - Production + Vite Build"
    echo "  ${YELLOW}npm run config:dev${NC}  - Nur Development-Config"
    echo "  ${YELLOW}npm run config:prod${NC} - Nur Production-Config"
    echo ""
}

# Hauptfunktion
main() {
    show_banner
    
    # Prüfen ob config file existiert
    if [ ! -f "$CONFIG_FILE" ] && [ "$1" != "help" ]; then
        echo -e "${RED}❌ Error: $CONFIG_FILE nicht gefunden!${NC}"
        exit 1
    fi
    
    case "$1" in
        "dev"|"development")
            echo -e "${GREEN}🔧 Aktiviere Development-Modus...${NC}"
            cp "$CONFIG_FILE" "$BACKUP_FILE" 2>/dev/null
            set_config "development" "true" "true"
            echo -e "${GREEN}✅ Development-Modus aktiviert!${NC}"
            echo ""
            show_status
            ;;
        "prod"|"production")
            echo -e "${BLUE}🏗️  Aktiviere Production-Modus...${NC}"
            cp "$CONFIG_FILE" "$BACKUP_FILE" 2>/dev/null
            set_config "production" "false" "false"
            echo -e "${GREEN}✅ Production-Modus aktiviert!${NC}"
            echo ""
            show_status
            ;;
        "status")
            show_status
            ;;
        "restore")
            if [ -f "$BACKUP_FILE" ]; then
                cp "$BACKUP_FILE" "$CONFIG_FILE"
                echo -e "${GREEN}✅ Backup wiederhergestellt!${NC}"
                echo ""
                show_status
            else
                echo -e "${RED}❌ Kein Backup gefunden!${NC}"
            fi
            ;;
        "help"|"-h"|"--help"|"")
            show_help
            ;;
        *)
            echo -e "${RED}❌ Unbekannter Befehl: $1${NC}"
            echo ""
            show_help
            exit 1
            ;;
    esac
}

# Skript ausführen
main "$1"