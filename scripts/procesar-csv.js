
/*
function formatoCSV() {
    console.log('Se presiono el boton');
}

var procesar = document.querySelector("button");
procesar.addEventListener("click", formatoCSV);*/

class TableCSVExporter {
    constructor (table, includeHeaders = true){
        this.table = table;
        this.rows = Array.from(table.querySelectorAll('tr'));

        console.log(this);
    }

    convertToCSV(){

    }

    _findLongestRowLength(){

    }

    static parseCell(tableCell){

    }

}