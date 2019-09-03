//编辑模块
define(["jquery", "task"], function ($, t) {
  var Edit = function () {
    this.questionArr = [];
    this.storageArr =paper;
    this.addQ();
    var self = this;



    // alert(2);
    //生成单向选择
    $("#single").click(function () {
      new t.Task().confirm({
        content: "请输入问题及选项",
        handler: function () {
          var q = $("#question").val(),
            a1 = $("#answer1").val(),
            a2 = $("#answer2").val(),
            a3 = $("#answer3").val();
          a4 = $("#answer4").val();
          score = $('#score').val();
          answers = $('input[name="radio"]:checked').val();
          self.produceRadio(q, a1, a2, a3, a4, score, answers);
          $(this).parent().parent().remove();
        },
        width: 466,
        height: 300,
        title: "提示",
        hasCloseBtn: true,
        skinClassName: null,
        mask: true,
        textBtn: "确认",
        textCal: "取消",
        el: self,
        radio: true,
        paper_type:paper_type,
        newBtn: true
      });
    });
    //生成多项选择
    $("#mult").click(function () {
      new t.Task().confirm({
        content: "请输入问题及选项",
        handler: function () {
          var q = $("#question").val(),
            a1 = $("#answer1").val(),
            a2 = $("#answer2").val(),
            a3 = $("#answer3").val(),
            a4 = $("#answer4").val(),
            score = $('#score').val(),
            answers =new Array();
            $('input[name="checkbox[]"]:checked').each(function(obj){
                answers[obj]=$(this).val();
            });
            self.produceMany(q, a1, a2, a3, a4, score, answers);
          $(this).parent().parent().remove();
        },
        width: 466,
        height: 300,
        title: "提示",
        hasCloseBtn: true,
        skinClassName: null,
        mask: true,
        textBtn: "确认",
        textCal: "取消",
        el: self,
        checkbox: true,
        newBtn: true
      });
    });
    $("#text").click(function () {
      new t.Task().confirm({
        content: "请输入文本问题（只输入问题项）",
        handler: function () {
          var q = $("#question").val();
          var score = $("#score").val();
          self.produceText(q, score);
          $(this).parent().parent().remove();
        },
        width: 466,
        height: 200,
        title: "提示",
        hasCloseBtn: true,
        skinClassName: null,
        mask: true,
        textBtn: "确认",
        textCal: "取消",
        el: self,
        textarea: true,
        newBtn: true
      });
    });
    $("#edit_body_list").click(function (e) {
      e = e || event;
      var target = e.target || e.srcElement;
      switch (target.id) {
        case "down":
          self.downFun(target);
          break;
        case "up":
          self.upFun(target);
          break;
        case "reuse":
          self.reuseFun(target);
          break;
        case "del":
          self.delFun(target);
          break;
      }
    });
    $("button:contains('发布')").click(function () {
      self.save();
    });
      self.paerrhtml();
  }
  Edit.prototype = {
    addQ: function () {
      $("#edit_add").click(function () {
        $(this).prev().slideDown(800);
      });
    },
    //问题数组操作按钮添加
    queFun: function () {
      var self = this;
      $.each(self.questionArr, function (key, val) {
        val.find("i").text(key + 1);
        if (key == 0) {
          val.find(".hand").html("<div id='down'>下移</div><div id='del'>删除</div>");
          $("#edit_body_list").append(val);
        } else if (key == self.questionArr.length - 1) {
          val.find(".hand").html("<div id='up'>上移</div><div id='del'>删除</div>");
          $("#edit_body_list").append(val);
        } else {
          val.find(".hand").html("<div id='up'>上移</div><div id='down'>下移</div>" +
            "<div id='del'>删除</div>");
          $("#edit_body_list").append(val);
        }
      });
    },
    //下移函数
    downFun: function (el) {
      var x = -20;
      $node = $(el).parent().parent();
      if ($node.next(":first").length == 0) {
        return;
      } else {
        for (var i = 0; i < this.questionArr.length; i++) {
          if (this.questionArr[i][0] == $node[0]) {
            x = i;
          }
        }
        this.changeArr(this.questionArr, x, x + 1);
        this.changeArr(this.storageArr, x, x + 1);
        this.queFun();
      }
    },
    //上移函数
    upFun: function (el) {
      var x = -20,
        $node = $(el).parent().parent();
      for (var i = 0; i < this.questionArr.length; i++) {
        if (this.questionArr[i][0] == $node[0]) {
          x = i;
        }
      }
      this.changeArr(this.questionArr, x, x - 1);
      this.changeArr(this.storageArr, x, x - 1);
      this.queFun();
    },
    //复用
    reuseFun: function (el) {
      if (this.questionArr.length >= 10) {
        alert("已经超出10个问题啦！");
        return;
      }
      var x = -20,
        $node = $(el).parent().parent(),
        nodeEl = $node.clone(true);
      for (var i = 0; i < this.questionArr.length; i++) {
        if (this.questionArr[i][0] == $node[0]) {
          x = i;
        }
      }
      this.questionArr.splice(x + 1, 0, nodeEl);
      this.storageArr.splice(x + 1, 0, nodeEl);
      this.queFun();
    },
    //删除
    delFun: function (el) {
      var x = -20,
        $node = $(el).parent().parent();
      $node.remove();
      for (var i = 0; i < this.questionArr.length; i++) {
        if (this.questionArr[i][0] == $node[0]) {
          x = i;
        }
      }
      this.questionArr.splice(x, 1);
      this.storageArr.splice(x, 1);
      this.queFun();
    },
    //数组顺序交换函数
    changeArr: function (arr, a, b) {
      var el = arr[a];
      arr[a] = arr[b];
      arr[b] = el;
      return arr;
    },
    //生成单选
    produceRadio: function (q, a1, a2, a3, a4, score, answers) {

      if (!q || !a1 || !a2 || !a3 || !a4 ) {
          layer.msg("请补全问卷!");
        return;
      }

      if(paper_type=='p' &&(!score || !answers)){
          layer.msg("请补全问卷!");
          return;
      }


      var a = [a1, a2, a3, a4];
      var answer = a.map((item,index)=>{
        return {
          id:index+1,
          title :item,
          status:parseInt(answers) == (index+1) ? true : false
        }
      })
      var cb = {
        id: this.questionArr.length + 1,
        type: "adio",
        title: q,
        score: parseInt(score) || 0,
        answer: answer,
      };
      this.storageArr.push(cb);
        var style="";
        if(paper_type=='q'){
            style="style='display:none;'";
        }
      var $que = $("<div class='que'>" +
        "<div class='queTitle'>Q" + "<i></i>" + "&nbsp&nbsp(单选题)&nbsp&nbsp" + q + "</i></div>" +
        "<div class='must' "+style+">分值:" + score + "</div>" +
        "<div class='queOption'><div>" +
        "<input type='radio' name="+cb.id+" "+ (answers == 1 && paper_type=='p'? 'checked':'') +" disabled>" + a1 + "</div>" +
        "<div><input type='radio' name="+cb.id+" "+ (answers == 2&& paper_type=='p'? 'checked':'') +" disabled>" + a2 + "</div>" +
        "<div><input type='radio' name="+cb.id+" "+ (answers == 3&& paper_type=='p'? 'checked':'') +" disabled>" + a3 + "</div>" +
        "<div><input type='radio' name="+cb.id+" "+ (answers == 4&& paper_type=='p'? 'checked':'') +" disabled>" + a4 + "</div>" +
        "</div>" +
        "<div class='hand'></div>" +
        "</div>");
      this.questionArr.push($que);
      this.queFun();
    },
    //生产多选
    produceMany: function (q, a1, a2, a3, a4, score, answers) {
        if (!q || !a1 || !a2 || !a3 || !a4 || !score || answers.length==0) {
            layer.msg("请补全问卷!");
            return;
        }

        var a = [a1, a2, a3, a4];
        var status=false;
        var answer = a.map((item,index)=>{
            status=false;
            for (i=0;i<answers.length;i++){
                if(parseInt(answers[i]) == (index+1)){
                    status=true;
                }
            }
            return {
                id:index+1,
                title :item,
                status:status,
            }
        })

        var cb = {
            id: this.questionArr.length + 1,
            type: "checkbox",
            title: q,
            score: parseInt(score) || 0,
            answer: answer,
        };
      this.storageArr.push(cb);

      var $que = $("<div class='que'>" +
        "<div class='queTitle'>Q" + "<i></i>" + "&nbsp&nbsp(多选题)&nbsp&nbsp" + q + "</i></div>" +
        "<div class='must'>分值:" + score + "</div>" +
        "<div class='queOption'><div>" +
        "<input type='checkbox' name="+cb.id+" "+ ($.inArray("1",answers)!=-1? 'checked':'') +" disabled>" + a1 + "</div>" +
        "<div><input type='checkbox' name="+cb.id+" "+ ($.inArray("2",answers)!=-1? 'checked':'') +" disabled>" + a2 + "</div>" +
        "<div><input type='checkbox' name="+cb.id+" "+ ($.inArray("3",answers)!=-1? 'checked':'') +" disabled>" + a3 + "</div>" +
        "<div><input type='checkbox' name="+cb.id+" "+ ($.inArray("4",answers)!=-1? 'checked':'') +" disabled>" + a4 + "</div>" +
        "</div>" +
        "<div class='hand'></div>" +
        "</div>");
      this.questionArr.push($que);
      this.queFun();
    },
    //产生文本题
    produceText: function (q, score) {
      if (!q) {
          layer.msg("请补全问卷!");
        return;
      }
        if(paper_type=='p' && !score){
            layer.msg("请补全问卷!");
            return;
        }
      var cb = {
        id: this.questionArr.length + 1,
        type: "textarea",
        score: parseInt(score) || 0,
        title: q,
        answer:[],
      };
      this.storageArr.push(cb);
      if (this.questionArr.length >= 100) {
          layer.msg("已经超出100个问题啦！");
        return;
      }
        var style="";
        if(paper_type=='q'){
            style="style='display:none;'";
        }
      var $que = $("<div class='que'>" +
        "<div class='queTitle'>Q" + "<i></i>" + "&nbsp&nbsp(文本题)&nbsp&nbsp" + q + "</i></div>" +
        "<div class='must' "+style+">分值:" + score + "</div>" +
        "<div class='queOption'><div>" +
        "<textarea rows='3' cols='20' id='textarea'></textarea></div>" +
        "</div>" +
        "<div class='hand'></div>" +
        "</div>");
      this.questionArr.push($que);
      this.queFun();
    },
    //存储函数
    save: function (sta) {
      if (this.storageArr.length == 0) {
        alert("问卷无问题！");
        return;
      }
        // var storage = window.localStorage;
      json = this.storageArr;
      json = JSON.stringify(json);
      // var key = 'questionnaire';
      console.log(json);
        ajax_post(document.getElementById("edit_footer_right").getAttribute('data-url'),{data:json});

      // if (storage) {
      //   storage.setItem(key, json);
      // }
    },
    paerrhtml:function(){
        var $que='';
        var style="";
        if(paper_type=='q'){
            style="style='display:none;'";
        }
        for (var i=0;i<paper.length;i++){
            if(paper[i]['type']=='adio'){
                $que = $("<div class='que'>" +
                    "<div class='queTitle'>Q" + "<i></i>" + "&nbsp&nbsp(单选题)&nbsp&nbsp" + paper[i]['title'] + "</i></div>" +
                    "<div class='must' "+style+">分值:" + paper[i]['score'] + "</div>" +
                    "<div class='queOption'><div>" +
                    "<input type='radio' name="+paper[i]['id']+" "+ (paper[i]['answer'][0]['status']&& paper_type=='p'? 'checked':'') +" disabled>" + paper[i]['answer'][0]['title'] + "</div>" +
                    "<div><input type='radio' name="+paper[i]['id']+" "+ (paper[i]['answer'][1]['status']&& paper_type=='p'? 'checked':'') +" disabled>" + paper[i]['answer'][1]['title'] + "</div>" +
                    "<div><input type='radio' name="+paper[i]['id']+"' "+ (paper[i]['answer'][2]['status']&& paper_type=='p'? 'checked':'') +" disabled>" + paper[i]['answer'][2]['title'] + "</div>" +
                    "<div><input type='radio' name="+paper[i]['id']+" "+ (paper[i]['answer'][3]['status']&& paper_type=='p'? 'checked':'') +" disabled>" + paper[i]['answer'][3]['title'] + "</div>" +
                    "</div>" +
                    "<div class='hand'></div>" +
                    "</div>");

            }else if(paper[i]['type']=='textarea'){
                 $que = $("<div class='que'>" +
                    "<div class='queTitle'>Q" + "<i></i>" + "&nbsp&nbsp(文本题)&nbsp&nbsp" + paper[i]['title']  + "</i></div>" +
                    "<div class='must' "+style+">分值:" + paper[i]['score'] + "</div>" +
                    "<div class='queOption'><div>" +
                    "<textarea rows='3' cols='20' id='textarea'></textarea></div>" +
                    "</div>" +
                    "<div class='hand'></div>" +
                    "</div>");
            }else if(paper[i]['type']=='checkbox'){
                $que = $("<div class='que'>" +
                    "<div class='queTitle'>Q" + "<i></i>" + "&nbsp&nbsp(多选题)&nbsp&nbsp" + paper[i]['title'] + "</i></div>" +
                    "<div class='must' >分值:" + paper[i]['score'] + "</div>" +
                    "<div class='queOption'><div>" +
                    "<input type='checkbox' name="+paper[i]['id']+" "+ (paper[i]['answer'][0]['status']&& paper_type=='p'? 'checked':'') +" disabled>" + paper[i]['answer'][0]['title'] + "</div>" +
                    "<div><input type='checkbox' name="+paper[i]['id']+" "+ (paper[i]['answer'][1]['status']&& paper_type=='p'? 'checked':'') +" disabled>" + paper[i]['answer'][1]['title'] + "</div>" +
                    "<div><input type='checkbox' name="+paper[i]['id']+"' "+ (paper[i]['answer'][2]['status']&& paper_type=='p'? 'checked':'') +" disabled>" + paper[i]['answer'][2]['title'] + "</div>" +
                    "<div><input type='checkbox' name="+paper[i]['id']+" "+ (paper[i]['answer'][3]['status']&& paper_type=='p'? 'checked':'') +" disabled>" + paper[i]['answer'][3]['title'] + "</div>" +
                    "</div>" +
                    "<div class='hand'></div>" +
                    "</div>");
            }
            this.questionArr.push($que);
            this.queFun();
        }
    },
  }
  return {
    Edit: Edit
  }
})