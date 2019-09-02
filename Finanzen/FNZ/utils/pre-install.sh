## Logo SVG Update
DIRECTORY=vendor/oro/platform/src/Oro/Bundle/UIBundle/Resources/public/img/
if [ -d "$DIRECTORY" ]; then
	/bin/cp -rf src/FNZBundle/Resources/public/themes/fnz/images/logo.svg vendor/oro/platform/src/Oro/Bundle/UIBundle/Resources/public/img/oro_icon.svg
	echo "Logo SVG updated."
else
	echo -e "Logo SVG ${RED}NOT updated.${NC} Not found Oro UIBundle public image folder: $DIRECTORY"
fi
