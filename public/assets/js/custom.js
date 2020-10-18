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
    return layer.open({
        type: 2,
        skin: 'layui-layer-lan',
        area: ['90%', '90%'],
        fixed: false, //不固定
        maxmin: true,
        title: title,
        content: content_url,
        end: end
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

