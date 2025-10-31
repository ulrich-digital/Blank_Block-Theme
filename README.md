# ulrichdigital Block Theme

Ein modulares Full-Site-Editing-Theme für WordPress, optimiert für die Blockentwicklung mit sass-Build-Prozess, variable Webfonts und benutzerdefinierte Farb- und Typografie-Vorgaben.

## Funktionen
- Vollständig kompatibel mit WordPress Full Site Editing (FSE)
- Eigene Farbpalette und Verlaufsdefinitionen
- Integration der variablen Schrift Rubik UD (normal & italic, 400–700)
- Unterstützt benutzerdefinierte Templates (z. B. Single ohne Titel)
- Sass-basierter Build-Prozess mit npm-Scripts build und watch


## Technische Hinweise
- Entwickelt mit Sass (via npm run build / npm run watch)
- Schrift-Einbindung und Typografie-Voreinstellungen in theme.json
- Variable Fonts werden als WOFF2 im Ordner assets/fonts/ verwaltet
- Layout-Breiten: contentSize: 100%, wideSize: 1000px
- Unterstützte Einheiten: px, em, rem, vw, %

## Build-Prozess
```
# CSS einmalig kompilieren
npm run build

# Automatische Überwachung bei der Entwicklung
npm run watch
```

<details>
<summary>Mehr anzeigen</summary>

- Punkt 1  
- Punkt 2  
- Punkt 3  

</details>

## Hinweise
- Hinweis zu Variable Fonts
    Frühere Probleme in WordPress 6.0 betrafen die Kombination mehrerer Font-Weights in einer einzigen `fontFace`-Deklaration (insbesondere in Chrome).
    Empfohlene Lösung bleibt weiterhin gültig:
    - **Jede Schriftstärke separat** in `theme.json` deklarieren
    - **Einzigartigen Fontnamen** verwenden, der sicher nicht systemweit installiert ist

    ```
    {
        "version": 2,
        "customTemplates":[],
        "settings": {
            "typography": {
                "fontFamilies": [
                    {
                        "fontFamily": "\"Rubik UD\", sans-serif",
                        "name": "Rubik UD",
                        "slug": "rubik",
                        "fontFace": [
                            {
                                "fontFamily": "Rubik UD",
                                "fontWeight": "400",
                                "fontStyle": "normal",
                                "fontStretch": "normal",
                                "src": [ "file:./fonts/Rubik-VariableFont_wght.woff2" ]
                            },
                            {
                                "fontFamily": "Rubik UD",
                                "fontWeight": "500",
                                "fontStyle": "normal",
                                "fontStretch": "normal",
                                "src": [ "file:./fonts/Rubik-VariableFont_wght.woff2" ]
                            }
                        ]
                    }
                ]
            }
        },

        "styles": {
            "elements": {
                "h2": {
                    "typography": {
                        "fontFamily": "Rubik UD",
                        "fontWeight": "500"
                    }
                }
            }
        }
    }
    ```

- Create Variable WOFF2 Fonts

    ```
    git clone --recursive https://github.com/google/woff2.git
    cd woff2
    ```
    In the woff2 directory:
    ```
    make clean all
    ./woff2_compress path-to-font/variable-font.ttf
    ```

    [https://henry.codes/writing/how-to-convert-variable-ttf-font-files-to-woff2/](https://henry.codes/writing/how-to-convert-variable-ttf-font-files-to-woff2/)



## Anforderungen
- WordPress ≥ 6.5
- PHP ≥ 8.0
- Node ≥ 18 (mit npm ≥ 8 für Build-Prozess)


## Autor
[ulrich.digital gmbh](https://ulrich.digital)

## Lizenz
GPL v2 or later
[https://www.gnu.org/licenses/gpl-2.0.html](https://www.gnu.org/licenses/gpl-2.0.html)
