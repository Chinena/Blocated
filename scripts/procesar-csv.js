
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
        //const numCols = this._findLongestRowLength();

        lines.push("telefono,carrier,monto,fecha,hora");

        for (const row of this.rows) {
            let line = "";

            //Telefono
            line += TableCSVExporter.parseCell(row.children[0]) + ',';
            //Carrier
            line += 'T,';
            //Monto
            line += TableCSVExporter.parseCell(row.children[3]) + ',';
            //Fecha Recarga
            line += TableCSVExporter.parseCell(row.children[1], 2) + ',';
            //Hora
            line += '00:05';

            lines.push(line);
        }
        /*
        for (const row of this.rows) {
            let line = "";

            for (let i = 0; i < numCols; i++) {
                if (row.children[i] !== undefined) {
                    line += TableCSVExporter.parseCell(row.children[i], i + 1);
                }

                line += (i !== (numCols - 1)) ? "," : "";
            }

            lines.push(line);
        }*/

        return lines.join("\n");
    }

    _findLongestRowLength() {    //Permite tomar a consideración las filas que tengan más columnas que los encabezados (en caso de ocurrir)
        return this.rows.reduce((length, row) => row.childElementCount > 1 ? row.childElementCount : length, 0);
    }

    static parseCell(tableCell, columnIndex) {
        let parsedValue = tableCell.textContent;

        //Remplaza todas las comillas dobles con dos comillas dobles
        parsedValue = parsedValue.replace(/"/g, `""`);

        //Si el valor contiene coma, nueva línea o comillas dobles, escríbalo entre comillas dobles
        //parsedValue = /[", \n]/.test(parsedValue) ? `"${parsedValue}"` : parsedValue;
        if (/[", \n]/.test(parsedValue)) {
            parsedValue = `"${parsedValue}"`;

        } else if (parsedValue.includes('-') && parsedValue.split('-').length === 3) {
            //Se va a modificar la estructura de la tabla para el formato que necesita la empresa 
            const parts = parsedValue.split('-');

            /*[0] es año, [1] es mes, [2] es dia ---> año-mes-dia */
            const day = parseInt(parts[2], 10);
            const month = parseInt(parts[1], 10) - 1;  // Restando 1 al mes
            const year = parseInt(parts[0], 10);

            const originalDate = new Date(year, month, day);

            const montoColumn = columnIndex + 1;
            const montoCell = tableCell.parentElement.children[montoColumn];
            const montoValue = montoCell.innerHTML.trim().replace(/\s+/g, '');
            if (montoValue === '$10') {
                originalDate.setDate(originalDate.getDate() + 8); // 7 días de caducidad para $10

            } else if (montoValue === '$50') {
                originalDate.setDate(originalDate.getDate() + 1);   // 1 día y
                originalDate.setMonth(originalDate.getMonth() + 1); // 1 mes de caducidad para $50

            }
            parsedValue = originalDate.toISOString().split('T')[0];

            /*if (columnIndex === 2) {
                // Ajustar la caducidad según el monto
                const montoColumn = columnIndex + 1;
                const montoCell = tableCell.parentElement.children[montoColumn];
                const montoValue = montoCell.innerHTML.trim().replace(/\s+/g, '');

                //console.log(montoColumn + ' , ' + montoCell + ' , ' + montoValue);

                if (montoValue === '$10') {
                    originalDate.setDate(originalDate.getDate() + 7); // 7 días de caducidad para $10

                } else if (montoValue === '$50') {
                    originalDate.setMonth(originalDate.getMonth() + 1); // 1 mes de caducidad para $50

                }

            } else if (columnIndex === 3) {
                // Operaciones específicas para fecha de recarga
                originalDate.setDate(originalDate.getDate() + 1);
            }
            parsedValue = originalDate.toISOString().split('T')[0];
            */
            /*
            if (columnIndex === 2) {
                // Operaciones específicas para fecha de recarga
                originalDate.setDate(originalDate.getDate() + 1);
            } else if (columnIndex === 3) {
                // Operaciones específicas para fecha de caducidad
                originalDate.setDate(originalDate.getDate() + 7);
            }
            parsedValue = originalDate.toISOString().split('T')[0];
            */

        }
        return parsedValue;
    }

}