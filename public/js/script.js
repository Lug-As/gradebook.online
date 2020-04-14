function insertTable(tableArray, tableTitle) {
    let table;
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
    let tablePosition, titlePosition;
    tablePosition = document.querySelector('#counting-modal .modal-body .modal-table');
    titlePosition = document.querySelector('#counting-modal .modal-header .modal-title');
    tablePosition.innerHTML = table;
    titlePosition.innerHTML = tableTitle;
}

$('body').on('click', '.plus-btn', function (e) {
    let student = $(this).data('student'),
        theme = $(this).data('theme'),
        url = "/lesson/mark";
    fetch(url, {
        method: "POST",
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: "student=" + student + "&theme=" + theme
    })
        .then(response => response.text())
        .then(result => {
            if (result.trim() !== "") {
                this.outerText = result;
            }
        });
});
let add_input = document.querySelector("#add-input");
if (add_input) {
    add_input.onkeyup = function (e) {
        let empty = this.value.trim() === "";
        document.querySelector("#button-add").disabled = empty;
    };
}
let button_add = document.querySelector("#button-add");
if (button_add) {
    button_add.onclick = function (e) {
        e.preventDefault();
        let theme = document.querySelector("#add-input").value.trim(),
            url = "/lesson/theme";
        document.querySelector("#add-input").value = "";
        this.disabled = true;
        fetch(url, {
            method: "POST",
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: "theme=" + theme
        })
            .then(response => response.text())
            .then(result => {
                if (result.trim() !== "") {
                    document.querySelector("#main-table").outerHTML = result;
                }
            });
    };
}
let button_add2 = document.querySelector("#button-add2");
if (button_add2) {
    button_add2.onclick = function (e) {
        e.preventDefault();
        let name = document.querySelector("#name-input").value.trim(),
            nick = document.querySelector("#nick-input").value.trim(),
            url = "/lesson/student";
        document.querySelector("#name-input").value = "";
        document.querySelector("#nick-input").value = "";
        fetch(url, {
            method: "POST",
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: "name=" + name + "&nick=" + nick,
        })
            .then(response => response.text())
            .then(result => {
                if (result.trim() !== "") {
                    document.querySelector("#main-table").outerHTML = result;
                }
            });
    };
}
let radios = document.querySelectorAll(".group-radio-input");
radios.forEach(function (element) {
    element.onclick = function () {
        let id = "#" + this.dataset.show;
        document.querySelectorAll(".group-input").forEach(function (elem) {
            elem.disabled = true;
            elem.hidden = true;
        });
        document.querySelector(id).disabled = false;
        document.querySelector(id).hidden = false;
    }
});
let student_button = document.querySelector("#student-button");
if (student_button) {
    student_button.onclick = function (e) {
        e.preventDefault();
        let name = document.querySelector("#student-input").value.trim(),
            nick = document.querySelector("#student-input-nick").value.trim(),
            url = "/add/new";
        document.querySelector("#student-input").value = "";
        document.querySelector("#student-input-nick").value = "";
        fetch(url, {
            method: "POST",
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: "name=" + name + "&nick=" + nick
        })
            .then(response => response.text())
            .then(result => {
                location.reload();
            });
    };
}
$('body').on('click', '#main-table tbody tr .trash-ico', function (e) {
    e.preventDefault();
    let student, url;
    student = this.dataset.student;
    url = "/lesson/delstudent";
    fetch(url, {
        method: "POST",
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: "student=" + student,
    })
        .then(response => response.text())
        .then(result => {
            if (result.trim() !== "") {
                document.querySelector("#main-table").outerHTML = result;
            }
        });
});
$('body').on('click', '#main-table tbody tr .edit-ico', function (e) {
    e.preventDefault();
    let student, type, text, input, parent, old_input;
    student = this.dataset.student.trim();
    type = this.dataset.tdType.trim();
    text = this.parentElement.childNodes[0].textContent;
    input = `<div class="input-group mb-3" id="new-name-block"><input type="text" value="${text}" class="form-control new-name-input" id="new-name-input" placeholder="Новое значение" aria-label="Новое значение" aria-describedby="confirm-btn"><div class="input-group-append"><button class="btn btn-outline-success" type="button" id="confirm-btn" data-student="${student}" data-td-type="${type}"><svg class="bi bi-check" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M13.854 3.646a.5.5 0 010 .708l-7 7a.5.5 0 01-.708 0l-3.5-3.5a.5.5 0 11.708-.708L6.5 10.293l6.646-6.647a.5.5 0 01.708 0z" clip-rule="evenodd"></svg></button></div></div>`;
    old_input = document.querySelector('#new-name-block');
    if (old_input) {
        return false;
    }
    parent = this.parentElement;
    parent.insertAdjacentHTML('beforeend', input);
    document.getElementById('new-name-input').focus();
});
$('body').on('blur', '#new-name-block', function (e) {
    document.getElementById('new-name-block').remove();
});
$('body').on('mousedown', '#confirm-btn', function (e) {
    e.preventDefault();
    let new_value;
    new_value = document.getElementById('new-name-input').value.trim();
    if (new_value === "") return false;
    let student, type, url;
    student = this.dataset.student.trim();
    type = this.dataset.tdType.trim();
    url = "/lesson/editstudent";
    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `student=${student}&type=${type}&value=${new_value}`,
    }).then(response => response.text())
        .then(result => {
            if (result.trim() !== "") {
                this.parentElement.parentElement.parentElement.childNodes[0].textContent = result.trim();
                document.querySelector('#new-name-input').blur();
            }
        });
});
$("body").on('click', '.lesson-list .lesson .del-btn', function (e) {
    e.preventDefault();
    let svg = this.firstElementChild,
        lesson = svg.dataset.lesson,
        url = "/main/dellesson",
        parentElement = this.parentElement.parentElement.parentElement.parentElement.parentElement;
    fetch(url, {
        method: "POST",
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: "lesson=" + lesson,
    })
        .then(response => response.text())
        .then(result => {
            parentElement.remove();
        });
});
let qty = document.getElementById('counting-btn');
if (qty) {
    qty.onclick = function (e) {
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
        insertTable(marks, 'Баллы за урок');
    }
}
let task = document.getElementById('task-btn');
if (task) {
    task.onclick = function (e) {
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