function ajaxRequest(url, body, onSuccessFunction = false, onErrorFunction = false) {
    let xhr = new XMLHttpRequest();
    xhr.open('POST', url, true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send(body);
    xhr.onreadystatechange = function () {
        if (this.readyState === 4) {
            let result = this.responseText;
            if (this.status === 200 && onSuccessFunction !== false) {
                onSuccessFunction(result);
            }
            if (this.status === 500 && onErrorFunction !== false) {
                onErrorFunction(result);
            }
        }
    }
}

function serializeSelectorsArray(selectorsArray) {
    let body;
    body = "";
    selectorsArray.forEach(function (selector) {
        let element = document.querySelector(selector);
        if (selector !== selectorsArray[0]) {
            body += "&";
        }
        body += element.name + "=" + element.value.trim();
        document.querySelector(selector).value = "";
    });
    return body;
}

function setMainTable(result) {
    document.getElementById("main-table").outerHTML = result;
}

function insertTable(tableArray, tableTitle) {
    let table, tablePosition, titlePosition;
    table = '<table class="table table-hover">' +
        '<thead class="thead-dark">' +
        '<tr><th scope="col">Ученик</th><th scope="col">Ник</th><th scope="col">Баллы</th></tr>' +
        '</thead>' +
        '<tbody>';
    tableArray.forEach(function (element) {
        table += '<tr> ';
        element.forEach(function (elem) {
            table += '<td> ';
            table += elem;
            table += '</td>';
        });
        table += '</tr>';
    });
    table += '</tbody></table>';
    tablePosition = document.querySelector('#counting-modal .modal-table');
    titlePosition = document.querySelector('#counting-modal .modal-title');
    tablePosition.innerHTML = table;
    titlePosition.innerHTML = tableTitle;
}

function disableByFilling(fillingIdsArray, disablingElementID) {
    let intersection;
    intersection = true;
    fillingIdsArray.forEach(function (id) {
        let isFilled = document.getElementById(id).value.trim() !== "";
        intersection = intersection && isFilled;
    });
    document.getElementById(disablingElementID).disabled = !intersection;
}

if (document.getElementById("add-input")) {
    document.getElementById("add-input").onkeyup = function (e) {
        disableByFilling(["add-input"], "button-add");
    };
}

if (document.getElementById("name-input") && document.getElementById("nick-input")) {
    document.getElementById("name-input").onkeyup = function () {
        disableByFilling(["name-input", "nick-input"], "button-add2")
    };
    document.getElementById("nick-input").onkeyup = function () {
        disableByFilling(["name-input", "nick-input"], "button-add2")
    };
}

if (document.getElementById("button-add")) {
    document.getElementById("button-add").onclick = function (e) {
        e.preventDefault();
        let body = serializeSelectorsArray(["#add-input"]);
        ajaxRequest("/lesson/theme", body, setMainTable);
        this.disabled = true;
    }
}

if (document.getElementById("button-add2")) {
    document.getElementById("button-add2").onclick = function (e) {
        e.preventDefault();
        let body = serializeSelectorsArray(["#name-input", "#nick-input"]);
        ajaxRequest("/lesson/student", body, setMainTable);
    };
}

let radios = document.querySelectorAll(".group-radio-input");
radios.forEach(function (element) {
    element.onclick = function () {
        let id = this.dataset.show;
        document.querySelectorAll(".group-input").forEach(function (elem) {
            elem.disabled = true;
            elem.hidden = true;
        });
        document.getElementById(id).disabled = false;
        document.getElementById(id).hidden = false;
    }
});

// -----------------------------
function pageReload() {
    location.reload();
}

// -----------------------------

if (document.querySelector("#student-button")) {
    document.querySelector("#student-button").onclick = function (e) {
        e.preventDefault();
        ajaxRequest("/add/new", ["#student-input", "#student-input-nick"], pageReload);
    };
}

document.querySelector('.main').onclick = function (e) {
    if (!e.target.closest("#new-name-block")) {
        if (document.querySelector('#new-name-block') && !e.target.closest(".edit-ico")) {
            document.querySelector('#new-name-block').remove();
        }
    }
};

document.querySelector('.main-content').onclick = function (e) {
    let target = e.target;
    if (target.closest('.trash-ico')) {
        let trash, student, body;
        trash = target.closest('.trash-ico');
        student = trash.dataset.student;
        body = "student=" + student;
        ajaxRequest("/lesson/delstudent", body, setMainTable);
    }
    if (target.closest('.plus-btn')) {
        let plus, student, theme, body;
        plus = target.closest('.plus-btn');
        student = plus.dataset.student;
        theme = plus.dataset.theme;
        body = `student=${student}&theme=${theme}`;
        ajaxRequest("/lesson/mark", body, function (result) {
            plus.outerText = result;
        });
    }
    if (target.closest('.edit-ico')) {
        let edit, student, type, text, input, parent, old_input;
        edit = target.closest('.edit-ico');
        student = edit.dataset.student.trim();
        type = edit.dataset.tdType.trim();
        text = edit.parentElement.childNodes[0].textContent;
        document.querySelectorAll("#new-name-block").forEach(function (element) {
            element.remove();
        });
        input = `<div class="input-group mb-3" id="new-name-block"><input type="text" value="${text}" class="form-control new-name-input" id="new-name-input" placeholder="Новое значение"><div class="input-group-append"><button class="btn btn-outline-success" type="button" id="confirm-btn" data-student="${student}" data-td-type="${type}"><svg class="bi bi-check" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M13.854 3.646a.5.5 0 010 .708l-7 7a.5.5 0 01-.708 0l-3.5-3.5a.5.5 0 11.708-.708L6.5 10.293l6.646-6.647a.5.5 0 01.708 0z" clip-rule="evenodd"></svg></button></div></div>`;
        old_input = document.querySelector('#new-name-block');
        if (old_input) {
            return false;
        }
        parent = edit.parentElement;
        parent.insertAdjacentHTML('beforeend', input);
        document.getElementById('new-name-input').focus();
    }
    if (target.closest('#confirm-btn')) {
        let new_value, confirm_btn;
        confirm_btn = target.closest('#confirm-btn');
        new_value = document.getElementById('new-name-input').value.trim();
        if (new_value === "") {
            alert("Необходимо заполнить поле");
        }
        let student, type, body;
        student = confirm_btn.dataset.student.trim();
        type = confirm_btn.dataset.tdType.trim();
        body = `student=${student}&type=${type}&value=${new_value}`;
        ajaxRequest("/lesson/editstudent", body, function (result) {
            if (result.trim() !== "") {
                confirm_btn.parentElement.parentElement.parentElement.childNodes[0].textContent = result.trim();
                if (document.getElementById('new-name-block')) {
                    document.getElementById('new-name-block').remove();
                }
            }
        });
    }
    if (target.closest('.lesson .del-btn')) {
        let del_btn, svg, body, lesson, lessonBlock, lessonBlockList;
        del_btn = target.closest('.lesson .del-btn');
        svg = del_btn.firstElementChild;
        lesson = svg.dataset.lesson;
        lessonBlock = del_btn.parentElement.parentElement.parentElement.parentElement.parentElement;
        lessonBlockList = lessonBlock.parentElement;
        body = `lesson=${lesson}`;
        ajaxRequest("/main/dellesson", body, function () {
            lessonBlock.remove();
            if (lessonBlockList.children.length === 1) {
                document.querySelector(".no-lessons").hidden = false;
            }
        });
    }
};

if (document.getElementById('counting-btn')) {
    document.getElementById('counting-btn').onclick = function (e) {
        e.preventDefault();
        let rows, marks;
        rows = document.querySelectorAll('#main-table tbody tr');
        marks = [];
        rows.forEach(function (element) {
            let cells, rowValues, row, length, notFound;
            cells = element.children;
            rowValues = [];
            row = [];
            notFound = true;
            length = cells.length;
            for (let i = 0; i < length; i++) {
                let item = cells.item(i);
                if (i === 0 || i === 1) {
                    row.push(item.firstChild.textContent);
                    continue;
                }
                let val = parseInt(item.firstChild.textContent);
                if (item.children.length === 0 && !isNaN(val)) {
                    rowValues.push(val);
                    notFound = false;
                }
            }
            if (length === 2 || notFound) {
                rowValues.push(0);
            }
            let sum = rowValues.reduce(function (a, b) {
                return a + b;
            });
            row.push(sum);
            marks.push(row);
        });
        marks.sort(function (a, b) {
            a = a[2];
            b = b[2];
            if (a < b) {
                return 1
            } else if (a === b) {
                return 0
            } else {
                return -1;
            }
        });
        insertTable(marks, 'Баллы за урок');
    }
}

if (document.getElementById('task-btn')) {
    document.getElementById('task-btn').onclick = function (e) {
        e.preventDefault();
        let rows, students;
        rows = document.querySelectorAll('#main-table tbody tr');
        students = [];
        rows.forEach(function (element) {
            let cells, row;
            cells = element.children;
            row = [];
            for (let i = 0; i < 2; i++) {
                row.push(cells.item(i).firstChild.textContent);
            }
            row.push('<button class="btn btn-success fast-task-btn">+</button>')
            students.push(row);
        });
        insertTable(students, 'Быстрое задание');
        let fastTaskBtns = document.querySelectorAll('.fast-task-btn');
        if (fastTaskBtns) {
            fastTaskBtns.forEach(function (btn) {
                btn.onclick = function (e) {
                    e.preventDefault();
                    this.outerHTML = 'Yeah man!';
                }
            });
        }
    }
}
let selectAll = document.getElementById('select-all');
if (selectAll) {
    selectAll.onchange = function (e) {
        e.preventDefault();
        document.querySelectorAll('.student-radio').forEach(function (radio) {
            radio.checked = selectAll.checked;
        });
    }
}