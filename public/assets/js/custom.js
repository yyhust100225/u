/**
 *
 * You can write your JS code here, DO NOT touch the default style file
 * because it will make it harder for you to update.
 *
 */

"use strict";

//去除字符串头部空格或指定字符
String.prototype.TrimStart = function (c) {
    if (c == null || c == "") {
        var str = this.replace(/^s*/, '');
        return str;
    } else {
        var rg = new RegExp("^" + c + "*");
        var str = this.replace(rg, '');
        return str;
    }
}

// 删除数组指定元素
let array_remove = function (val, arr) {
    console.log('delete:'+val);
    let index = arr.indexOf(val);
    console.log('index:'+index);
    arr.splice(index, 1);
}

// js带参路由获取
let route = (routeUrl, param) => {
    let append = [];

    for (let x in param) {
        let search = '{' + x + '}';

        if (routeUrl.indexOf(search) >= 0) {
            routeUrl = routeUrl.replace('{' + x + '}', param[x]);
        } else {
            append.push(x + '=' + param[x]);
        }
    }

    let url = '/' + routeUrl.trimStart();

    if (append.length === 0) {
        return url;
    }

    if (url.indexOf('?') >= 0) {
        url += '&';
    } else {
        url += '?';
    }

    url += append.join('&');

    return url;
}

// 弹出表单框 参数初始化
var makeLayerForm = function(layer, title, content_url, end){

    if(typeof arguments[3] === 'undefined')
        end = null;

    return layer.open({
        type: 2,
        skin: 'layui-layer-lan',
        area: ['90%', '90%'],
        fixed: false, //不固定
        maxmin: true,
        title: title,
        content: content_url,
        end: end,
        cancel: function(index, layero){
            layer.close(index)
            return false;
        }
    });
}

let deleteTd = function(classname) {
    let cn = arguments[0] ? arguments[0] : 'delete-td';
    let $ = layui.$;
    $('.' + cn).on('click', function(){
        $(this).parents('td').remove();
    });
}

let deleteTr = function(classname) {
    let cn = arguments[0] ? arguments[0] : 'delete-tr';
    let $ = layui.$;
    $('.' + cn).on('click', function(){
        $(this).parents('tr').remove();
    });
}

let formSubmit = function(data, type, url, success_code){
    let $ = layui.$;
    $.ajax({
        type: type,
        url: url,
        data: data,
        dataType: 'json',
        async: false,
        success: function(res){
            if(res.code === success_code) {
                let index = parent.layer.getFrameIndex(window.name);
                layer.msg(res.message, {time: 1000}, function(){
                    parent.layer.close(index);
                });
            } else {
                layer.msg(res.message);
            }
        }, error: function(e){
            if(e.status === 422) {
                $.each(e.responseJSON.errors, function(k,v){
                    layer.msg(v[0]);
                    return false;
                });
            }
            else {
                console.log(e);
                layer.msg(e.responseJSON.message);
            }
        }
    });
    return false;
}

// 带精度计算
let floatObj = function () {

    /*
     * 判断obj是否为一个整数
     */
    function isInteger(obj) {
        return Math.floor(obj) === obj
    }

    /*
     * 将一个浮点数转成整数，返回整数和倍数。如 3.14 >> 314，倍数是 100
     * @param floatNum {number} 小数
     * @return {object}
     *   {times:100, num: 314}
     */
    function toInteger(floatNum) {
        var ret = {times: 1, num: 0};
        if (isInteger(floatNum)) {
            ret.num = floatNum;
            return ret
        }
        var strfi = floatNum + '';
        var dotPos = strfi.indexOf('.');
        var len = strfi.substr(dotPos + 1).length;
        var times = Math.pow(10, len);
        var intNum = parseInt(floatNum * times + 0.5, 10);
        ret.times = times;
        ret.num = intNum;
        return ret
    }

    /*
     * 核心方法，实现加减乘除运算，确保不丢失精度
     * 思路：把小数放大为整数（乘），进行算术运算，再缩小为小数（除）
     *
     * @param a {number} 运算数1
     * @param b {number} 运算数2
     * @param op {string} 运算类型，有加减乘除（add/subtract/multiply/divide）
     *
     */
    function operation(a, b, op) {
        var o1 = toInteger(a);
        var o2 = toInteger(b);
        var n1 = o1.num;
        var n2 = o2.num;
        var t1 = o1.times;
        var t2 = o2.times;
        var max = t1 > t2 ? t1 : t2;
        var result = null;
        switch (op) {
            case 'add':
                if (t1 === t2) { // 两个小数位数相同
                    result = n1 + n2
                } else if (t1 > t2) { // o1 小数位 大于 o2
                    result = n1 + n2 * (t1 / t2)
                } else { // o1 小数位 小于 o2
                    result = n1 * (t2 / t1) + n2
                }
                return result / max;
            case 'subtract':
                if (t1 === t2) {
                    result = n1 - n2
                } else if (t1 > t2) {
                    result = n1 - n2 * (t1 / t2)
                } else {
                    result = n1 * (t2 / t1) - n2
                }
                return result / max;
            case 'multiply':
                result = (n1 * n2) / (t1 * t2);
                return result;
            case 'divide':
                result = (n1 / n2) * (t2 / t1);
                return result
        }
    }

    // 加减乘除的四个接口
    function add(a, b) {
        return operation(a, b, 'add')
    }

    function subtract(a, b) {
        return operation(a, b, 'subtract')
    }

    function multiply(a, b) {
        return operation(a, b, 'multiply')
    }

    function divide(a, b) {
        return operation(a, b, 'divide')
    }

    // exports
    return {
        add: add,
        subtract: subtract,
        multiply: multiply,
        divide: divide
    }
}();

// 多选框初始化
let multi_select_init = function(elem, name, data, on) {
    if(typeof arguments[3] === 'undefined')
        on = function(){ return false; };
    return xmSelect.render({el: '#' + elem, language: 'zn', filterable: true, autoRow: true, name: name, data: data, on: on});
}

