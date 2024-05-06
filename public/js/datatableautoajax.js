class datatables_ajax
{
    run_initializer = true
    constructor(url, id_table_body, callback_format_string) {
        this.url = url;
        this.id_table_body = id_table_body;
        this.callback_format_string = callback_format_string;
    }

    do_append(data) {
        console.log(data)
        $(this.id_table_body).empty()
        for(let i = 0; i < data.length; i++) {
            var html = this.callback_format_string((i + 1), data[i]);
            console.log(html)
            $(this.id_table_body).append(html)
        }
        if (this.run_initializer == true) {
            $('#table-kelas').DataTable({searching: false})
        }
        
        
    }

    peform_req() {
        fetch(this.url)
        .then(response => response.json())
        .then(data => this.do_append(data));
    }

    exec() {
        this.peform_req()
    }

    update() {
        this.run_initializer = false
        this.exec()
    }
}