// rotate canvas
function rotate(ctx, rad) {
    ctx.translate(w / 2, h / 2)
    ctx.rotate(rad);
    ctx.translate(-w / 2, -h / 2)
}

// translate to R square
function shift(back = false) {
    if (back)
        ctx.translate(-canvasW / 8, -canvasH / 8);
    else
        ctx.translate(canvasW / 8, canvasH / 8);
}

// draw graph and marks
function drawGraph(ctx) {
    ctx.beginPath();
    // horizontal line
    ctx.moveTo(0, canvasH / 2);
    ctx.lineTo(canvasW, canvasH / 2);
    // x - arrow
    ctx.moveTo(canvasW * 0.97, canvasH * 0.53);
    ctx.lineTo(canvasW, canvasH / 2);
    ctx.lineTo(canvasW * 0.97, canvasH * 0.47);
    // vertical line
    ctx.moveTo(canvasW / 2, 0);
    ctx.lineTo(canvasW / 2, canvasH);
    // y - arrow
    ctx.moveTo(canvasW * 0.47, canvasH * 0.03);
    ctx.lineTo(canvasW / 2, 0);
    ctx.lineTo(canvasW * 0.53, canvasH * 0.03);

    shift();

    ctx.font = "15px Arial";
    ctx.fillStyle = "black";
    let labels = [[0, "-R"], [w / 4, "-R/2"], [3 * w / 4, "R/2"], [w, "R"]]
    // x marks
    for (let [x, text] of labels) {
        ctx.moveTo(x, h * 0.48);
        ctx.lineTo(x, h * 0.52);
        ctx.fillText(text, x, h * 0.45);
    }
    // y marks
    for (let [y, text] of labels) {
        ctx.moveTo(w * 0.48, h - y);
        ctx.lineTo(w * 0.52, h - y);
        ctx.fillText(text, w * 0.55, h - y);
    }
    ctx.stroke();
    shift(true);
}

function drawRectangle(ctx, width, height) {
    ctx.beginPath();
    ctx.moveTo(w / 2, h / 2); // Move to the center of the circle
    ctx.lineTo(w / 2, h / 2 - height);
    ctx.lineTo(w / 2 - width, h / 2 - height);
    ctx.lineTo(w / 2 - width, h / 2);
    ctx.lineTo(w / 2, h / 2);
}

function drawRhombus(ctx, width, height) {
    ctx.beginPath();
    ctx.moveTo(w / 2, h / 2); // Move to the center of the circle
    ctx.lineTo(w / 2, h / 2 - height);
    ctx.lineTo(w / 2 - width, h / 2);
    ctx.lineTo(w / 2, h / 2);
}

function drawCircle(ctx, radius) {
    let startAngle = Math.PI;
    let endAngle = -Math.PI / 2; // -90 degrees
    let counterclockwise = false;

    ctx.beginPath();
    ctx.moveTo(w / 2, h / 2); // Move to the center of the circle
    ctx.arc(w / 2, h / 2, radius, startAngle, endAngle, counterclockwise);
    ctx.lineTo(w / 2, h / 2); // Connect back to the center
}

function redraw() {
    ctx.clearRect(0, 0, canvasW, canvasH);
    // draw figures
    shift();
    for (let i = 1; i <= 4; i++) {
        let type = document.getElementById(`figure${i}`).value
        let radius = (document.getElementById(`radius${i}`).value === "r/2") ? h / 4 : h / 2
        let width = (document.getElementById(`width${i}`).value === "r/2") ? w / 4 : w / 2
        let height = (document.getElementById(`height${i}`).value === "r/2") ? h / 4 : h / 2

        if (i % 2 === 0)
            [height, width] = [width, height]

        switch (type) {
            case "rectangle":
                drawRectangle(ctx, width, height);
                break;
            case "circle":
                drawCircle(ctx, radius);
                break;
            case "rhombus":
                drawRhombus(ctx, width, height);
                break;
            default:
                rotate(ctx, Math.PI / 2);
                continue;
        }
        ctx.fillStyle = "cyan";
        ctx.fill();
        rotate(ctx, Math.PI / 2);
    }

    // draw graph
    shift(true);
    drawGraph(ctx);
}

function getParam(array, name) {
    for (let index = 0; index < array.length; index++) {
        if (array[index].name == name) {
            return array[index].value;
        }
    }
    return null;
}

function setParam(array, name, value) {
    for (let index = 0; index < array.length; index++) {
        if (array[index].name == name) {
            array[index].value = value;
            return;
        }
    }
    array.push({"name": name, "value": value})
}

function drawPoint(x, y, r, color) {
    ctx.beginPath();
    ctx.arc(x, y, r, 0, 2 * Math.PI);
    ctx.fillStyle = color;
    ctx.fill();
}

// get canvas
let canvas = document.getElementById("myCanvas");
let ctx = canvas.getContext("2d");

let canvasH = canvas.height;
let canvasW = canvas.width;

let h = canvasH * 3 / 4;
let w = canvasW * 3 / 4;
redraw()

// event listeners
// canvas click - show point
canvas.addEventListener("mousedown", function (event) {
    let formData = $("#point-form").serializeArray();

    let r = parseFloat(getParam(formData, "r"));
    if (isNaN(r) || r <= 0)
        return;

    let rect = canvas.getBoundingClientRect();
    let mouseX = event.clientX - rect.left;
    let mouseY = event.clientY - rect.top;

    let canvasX = mouseX - canvas.width / 2;
    let canvasY = -(mouseY - canvas.height / 2);

    let x = (canvasX / (w / 2) * r).toFixed(2);
    let y = (canvasY / (h / 2) * r).toFixed(2);

    setParam(formData, "x", x);
    setParam(formData, "y", y);
    setParam(formData, "clickHandle", "true");

    $.get({
        url: "app",
        data: formData,
        success: function (response) {
            let color = (response.trim() == "true") ? "green" : "red";
            drawPoint(mouseX, mouseY, 3, color)
        }
    })
});

// select change
let redraws = document.getElementsByClassName("redraw");
for (let i = 0; i < redraws.length; i++) {
    redraws[i].addEventListener("change", redraw);
}


