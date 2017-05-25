<template>
  <div id="daily">
      <div class="col-md-offset-3 col-md-6">
        <form class="form-horizontal">
            <span class="heading">X月X日工作日志</span>

            <div class="form-group">
                <button type="submit">提交</button>
            </div>
        </form>
      </div>
</div>
</template>

<script>
export default {
  name: 'daily'
}
</script>

<style>
#daily{
  padding: 1.5em;
  background-color: #EBEBEB;
}
.form-horizontal{
    background: #fff;
    border-radius: 8px;
    text-align: center;
    -webkit-box-shadow: #666 0px 0px 10px;
    -moz-box-shadow: #666 0px 0px 10px;
    box-shadow: #666 0px 0px 10px;
}
.form-horizontal .heading{
  display: block;
  font-size: 2em;
  padding: .5em 0;
  border-bottom: 1px solid #f0f0f0;
  margin-bottom: 2rem;
}
.form-horizontal .form-group{
    padding: 0 40px;
    margin: 0 0 1.5rem 0;
    position: relative;
}
.form-horizontal .form-control{
    background: #f0f0f0;
    border: none;
    border-radius: 20px;
    box-shadow: none;
    padding: 0 20px 0 45px;
    height: 40px;
    transition: all 0.3s ease 0s;
}
.form-horizontal .form-control:focus{
    background: #e0e0e0;
    box-shadow: none;
    outline: 0 none;
}
.form-horizontal .form-group i{
    position: absolute;
    top: 12px;
    left: 60px;
    font-size: 17px;
    color: #c8c8c8;
    transition : all 0.5s ease 0s;
}
.form-horizontal .form-control:focus + i{
    color: #00b4ef;
}
.form-horizontal .fa-question-circle{
    display: inline-block;
    position: absolute;
    top: 12px;
    right: 60px;
    font-size: 20px;
    color: #808080;
    transition: all 0.5s ease 0s;
}
.form-horizontal .fa-question-circle:hover{
    color: #000;
}
.form-horizontal .btn{
    float: right;
    font-size: 14px;
    color: #fff;
    background: #00b4ef;
    border-radius: 30px;
    padding: 10px 25px;
    border: none;
    text-transform: capitalize;
    transition: all 0.5s ease 0s;
}
@media only screen and (max-width: 479px){
    .form-horizontal .form-group{
        padding: 0 25px;
    }
    .form-horizontal .form-group i{
        left: 45px;
    }
    .form-horizontal .btn{
        padding: 10px 20px;
    }
}
</style>
