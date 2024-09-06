// Vuetify
import "vuetify/styles";
import { createVuetify } from "vuetify";
import * as components from "vuetify/components";
import * as directives from "vuetify/directives";
import {aliases,mdi} from "vuetify/iconsets/mdi-svg";

const customeTheme = {
    dark: false,
    colors: {
        primary: 'rgb(255,112,0)',
        secondary: 'rgb(255,172,74)',
        accent:'rgb(255,112,0)',
        error: "#FF5252",
        info: "#2196F3",
        success: "#4CAF50",
        warning: "#FFC107",
        gray: "#797575",
    },
    icons: {
        defaultSet: 'mdi',
        aliases,
        sets: {
            mdi,
        },
    },
};

const vuetify = createVuetify({
    components,
    directives,
    theme: {
        defaultTheme: "customeTheme",
        themes: {
            customeTheme,
        },
    },
});

export default vuetify;
