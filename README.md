# My Bakery
This is a simple bakery dynamic website made with PHP and Mariadb/Mysql. 

## Features
- Dynamic Page content.
- Menu Page.
- Cart Page.
- Login and Signup System.
- Admin page for adding for updating the menu.


## License
MIT License

## Build 
This project has no dependencies and can work by just changing the config/config.php file
$gMode variable to Modes::Development so you don't need bundle the asset files.
Otherwise you will need NPM to run esbuild:

```bash
npm install
npm run build
```

This will generate the bundle assets that can be used by the php in production mode.
