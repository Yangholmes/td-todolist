# td-todolist

> TD TODOLIST

## Build Setup

``` bash
# install dependencies
npm install

# serve with hot reload at localhost:8080
npm run dev

# build for production with minification
npm run build
```

For detailed explanation on how things work, consult the [docs for vue-loader](http://vuejs.github.io/vue-loader).

# 个人工作看板  (钉钉微应用)

### 代码规范
1. 命名规则
 * 文件名

    * 文件名涉及url路径，统一使用"\-"连字符连接。
 * HTML
 * CSS
 * JavaScript

    * 常量：全部大写，单词以下划线"\_"区分。
    * 变量（属性）：按照驼峰法命名，首字母小写。例如：firstVar 是正确的变量名，FirstVar 、firstvar 或者FIRVAR都是错误的。私有属性应在变量名前面加上下划线"\_"。例如_secondVar。
    * 函数（方法）：命名规则与变量名相同。
    * 类：类的命名按照帕斯卡命名法，为了和属性、方法有所区分，首字母应大写。例如FirstObject 是正确的命名。
    * 文件名：全部小写，单词以连接符"-"区分，切勿使用其他符号。
 * php

    * 常量：全部大写，单词以下划线"\_"区分。
    * 变量（属性）：按照驼峰法命名，首字母小写。
    * 函数（方法）：按照驼峰法命名，首字母小写。
    * 类：类的命名必须遵循 StudlyCaps 帕斯卡命名规范；

        类中的常量所有字母都必须大写，单词间用下划线分隔；

        方法名称必须符合 camelCase 式的小写开头驼峰命名规范
    * 文件名：全部小写，单词以连接符"-"区分，切勿使用其他符号。

  * JAVA

2. 字符编码

    必须且只可使用不带BOM的UTF-8编码。
