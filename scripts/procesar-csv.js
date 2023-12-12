
/*
function formatoCSV() {
    console.log('Se presiono el boton');
}

var procesar = document.querySelector("button");
procesar.addEventListener("click", formatoCSV);*/

class TableCSVExporter {
    constructor(table, includeHeaders = true) {
        this.table = table;
        this.rows = Array.from(table.querySelectorAll('tr'));   //toma todos los <tr> de la tabla (incluido los headers)

        if (!includeHeaders && this.rows[0].querySelectorAll('th').length) {
            this.rows.shift(); // cuando enviamos de parametros Headers como 'false', elimina los encabezados
        }
    }

    convertToCSV() {
        const lines = [];
        const numCols = this._findLongestRowLength();

        for (const row of this.rows) {
            let line = "";

            for (let i = 0; i < numCols; i++) {
                if (row.children[i] !== undefined) {
                    line += TableCSVExporter.parseCell(row.children[i]);
                }

                line += (i !== (numCols - 1)) ? "," : "";
            }

            lines.push(line);
        }
        
        return lines.join("\n");
    }

    _findLongestRowLength() {    //Permite tomar a consideración las filas que tengan más columnas que los encabezados (en caso de ocurrir)
        return this.rows.reduce((length, row) => row.childElementCount > 1 ? row.childElementCount : length, 0);
    }

    static parseCell(tableCell) {
        let parsedValue = tableCell.textContent;

        //Remplaza todas las comillas dobles con dos comillas dobles
        parsedValue = parsedValue.replace(/"/g, `""`);

        //Si el valor contiene coma, nueva línea o comillas dobles, escríbalo entre comillas dobles
        parsedValue = /[", \n]/.test(parsedValue) ? `"${parsedValue}"` : parsedValue;
        /*
        if (/[", \n]/.test(parsedValue)) {
            parsedValue = `"${parsedValue}"`;
        } else {
            // En caso contrario, mantener el valor sin cambios
            parsedValue = parsedValue;
        }*/

        return parsedValue;
    }

}