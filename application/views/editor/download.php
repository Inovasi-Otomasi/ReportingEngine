<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>IAN Platform - Login Page</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link href="<?= base_url('assets/') ?>fontawesome/css/fontawesome.css" rel="stylesheet" />
        <link href="<?= base_url('assets/') ?>fontawesome/css/brands.css" rel="stylesheet" />
        <link href="<?= base_url('assets/') ?>fontawesome/css/solid.css" rel="stylesheet" />
        <link rel="stylesheet" href="<?= base_url("assets/css/style.css") ?>">
    </head>
    <body>
        <div class="border rounded-pill p-1 my-3 bg-dark" style="width:100%;">
            <div class="loading-bar bg-glass rounded-pill" style="height:10px; width:0%; transition: width 2s"></div>
        </div>
        <script
            src="https://code.jquery.com/jquery-3.7.1.min.js"
            integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
            crossorigin="anonymous"
        ></script>
        <script 
            src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" 
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" 
            crossorigin="anonymous"
        ></script>

        <script>
            let queries = <?= json_encode($query) ?>;
            let itterate = <?= json_encode($itterate) ?>;
            let template = <?= json_encode($template) ?>;
            let reps = "<?= $report ?>";
            let file = template.file
            let sheets = JSON.parse(template.sheets)

            function getColumn(number) {
                let columnName = '';
                while (number > 0) {
                    let remainder = (number - 1) % 26;
                    columnName = String.fromCharCode(65 + remainder) + columnName;
                    number = Math.floor((number - 1) / 26);
                }
                return columnName;
            }

            function getNumber(columnName) {
                let number = 0;
                for (let i = 0; i < columnName.length; i++) {
                    let charValue = columnName.charCodeAt(i) - 64;
                    number = number * 26 + charValue;
                }
                return number;
            }

            queryResult = {};
            generated = ""

            let functions = {}
            let names = {}

            <?php foreach($array as $ar): ?>            
                functions['function<?= $ar->id ?>'] = function(){
                    function run(query) {
                        <?= $ar->code ?>
                    }
                    returned = run(queryResult);
                    if(typeof returned === "undefined"){
                        returned = [];
                    } else {
                        if(!Number.isInteger(returned.length)){
                            returned = [];   
                        }
                    }
                    return returned;
                }
            <?php endforeach ?>  

            <?php foreach($array as $ar): ?>  
                names["<?= $ar->name ?>"] = 'function<?= $ar->id ?>'
            <?php endforeach ?>            

            function processName(str) {
                // Use a regular expression to find the placeholders like {{header[0]}}
                return str.replace(/{{(.*?)\[(\d+)\]}}/g, (match, name, index) => {
                    const functionName = names[name]; // Get the corresponding function name from 'names'
                    
                    if (functionName && functions[functionName]) {
                        const array = functions[functionName](); // Call the function to get the array
                        return array[parseInt(index)] || ""; // Return the value from the array or an empty string if index is out of bounds
                    }
                    
                    return str; // Return an empty string if no matching function is found
                });
            }

            function createGet(id) {
                let jsonObjects = queries
                let ids = JSON.parse(id)
                const params = {};

                jsonObjects.forEach(obj => {
                    if (ids.includes(obj.id) && obj.get !== null) {
                        const urlParams = new URLSearchParams(obj.get);
                        urlParams.forEach((value, key) => {
                            params[key] = value;
                        });
                    }
                });

                const urlParam = new URLSearchParams(window.location.search);
                urlParam.forEach((value, key) => {
                    params[key] = value;
                });

                
                return new URLSearchParams(params).toString();
            }

            $(document).ready(function(){
                let ids = JSON.parse('<?= $queries ?>')
                let get = createGet('<?= $queries ?>')

                let limit = 100;

                let i = 0
                let counter = []
                let endresult = []
                let nQuery = 0;
                let process = 0;
                let doneCount = 0;

                if(generated != get){
                    count()
                    generated = get
                } else {
                    doner()
                }

                function count(){
                    loader(0)
                    if(i < ids.length){
                    i++;
                    $.ajax({
                        type: "POST",
                        url: "<?= base_url("index.php/process/countQuery/?") ?>" + get,
                        async: true,
                        data: { id: ids[i-1] },
                        success: function(res) {
                            res = JSON.parse(res);
                            if (!res.err) {
                                counter.push({ count: res.data[0].count, id: ids[i-1] });
                            }
                            count()
                        },
                        error: function(xhr, status, error) {
                            console.log(error);
                            count()
                        }
                    });
                    } else {
                        nQuery = 0;
                        process = 0;
                        endresult = []
                        doneCount = 0;
                        getData()
                    }
                }

                function getData(){
                    let max = 0;
                    counter.forEach(function(n){
                    max += parseInt(n.count)
                    })
                    max += limit;
                    let prog = 100 * (doneCount/max)
                    loader(prog)
                    if(nQuery < counter.length){
                        if(process < parseInt(counter[nQuery].count)){
                            let id = parseInt(counter[nQuery].id) 
                            $.ajax({
                                type: "POST",
                                url: "<?= base_url("index.php/process/getQuery?") ?>" + get,
                                data : {
                                    id,limit,offset: process
                                },
                                success: function(res){
                                    process += limit
                                    
                                    let data = JSON.parse(res);
                                    data = data.data;

                                    endresult = endresult.concat(data)
                                    doneCount += data.length
                                    getData()
                                }
                            })
                        } else {
                            let name = "unamed"
                            queries.forEach(function(ar){
                            if(counter[nQuery].id == ar.id){
                                name = ar.name
                            }
                            });
                            queryResult[name] = endresult;
                            nQuery ++;
                            process = 0;
                            endresult = []
                            getData()
                        }
                    } else {
                        loader(100);
                        doner();
                    }
                }

                function loader(width){
                    if(width > 100){
                        width = 100
                    }
                    $(".loading-bar").css('width',width+'%');
                }

            });

            function doner(){
                // console.log(functions.function6());
                reps = processName(reps)
                let report = {};
                itterate.forEach(function(o){
                    // console.log(o);
                    let sheet = sheets[o.sheet]
                    if(report[sheet] === undefined){
                        report[sheet] = {}
                    }
                    let data = functions[`function${o.array_id}`]()
                    let limiter = 0;
                    if(o.limit == 0){
                        limiter = data.length
                    } else {
                        limiter = o.limit
                    }
                    
                    if(o.direction == 1){ // horizontal
                        let a = 0;
                        for (let i = o.offset; i < limiter; i++) {
                            if(data[i] !== undefined && a < 16384){
                                const element = data[i];
                                let col = getColumn(parseInt(a) + getNumber(o.col))
                                let row = o.row
                                report[sheet][col + row] = {}
                                report[sheet][col + row].value = element
                                report[sheet][col + row].id = o.id

                                a++;
                            }
                        }
                    } else { // vertical
                        let a = 0;
                        for (let i = o.offset; i < limiter; i++) {
                            if(data[i] !== undefined){
                                const element = data[i];
                                let col = o.col
                                let row = parseInt(a) + parseInt(o.row)
                                report[sheet][col + row] = {}
                                report[sheet][col + row].value = element
                                report[sheet][col + row].id = o.id
                                a++;
                            }
                        }
                    }
                })

                submitForm(report)
            }

            function submitForm(report) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '<?= base_url("index.php/editor/generate/") ?>';

                const dataInput = document.createElement('input');
                dataInput.type = 'hidden';
                dataInput.name = 'data';
                dataInput.value = JSON.stringify(report);
                form.appendChild(dataInput);

                const nameInput = document.createElement('input');
                nameInput.type = 'hidden';
                nameInput.name = 'name';
                nameInput.value = reps;
                form.appendChild(nameInput);

                const fileInput = document.createElement('input');
                fileInput.type = 'hidden';
                fileInput.name = 'file';
                fileInput.value = file;
                form.appendChild(fileInput);

                document.body.appendChild(form);

                form.submit();
            }

        </script>
        
    </body>
</html>