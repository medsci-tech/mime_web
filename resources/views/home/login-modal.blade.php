<div class="tiny reveal" id="exampleModal1" data-reveal style="border: none;">
  <div class="row column">
    <br>
    <form action="/home/login" method="post">
      <div class="row column log-in-form">
        <h4 class="text-center">Mime账号登录</h4>
        <label>手机号
          <input type="text" placeholder="请输入您的手机号" name="phone" v-model="phone">
        </label>
        <label>密码
          <input type="text" placeholder="请输入密码" name="password" v-model="password">
        </label>
        <p id="login-error" class="help-text hide">您输入的手机号码或者密码有误</p>
        <input id="remember-me" type="checkbox" v-model="remember"><label for="remember-me">记住我</label>
        <p><button @click="login" type="button" class="button expanded">登&emsp;录</button></p>
        <p class="text-center"><a href="/home/register/create">没有账号?点击注册</a></p>
      </div>
    </form>
    <br>
  </div>
</div>
<script>
  login = new Vue({
    el: '.reveal',
    data: {
      phone: null,
      password: null,
      remember: null
    },
    methods: {
      login: function () {
        $.post('/home/login',$data,function(data){
          if(data.success){
            $('#exampleModal1').foundation('close');
            $('#login-error').addClass('hide');
          }else{
            $('#login-error').removeClass('hide');
          }
        })
      }
    }
  });
</script>

