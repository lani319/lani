<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<script language="Javascript" type="text/javascript">
var obj = {
        apikey: "{e5020c809bc23c99a80970fc001f7cf586b248a0}",
        init : function()
        {
                obj.q = document.getElementById('q');
                obj.b = document.getElementById('b');
                obj.r = document.getElementById('r');
                obj.b.onclick = obj.pingSearch;
        },
        // �˻��� ��û�ϴ� �Լ� 
         pingSearch : function()
         {
            if (obj.q.value)
            {
              obj.s = document.createElement('script');
              obj.s.type ='text/javascript';
              obj.s.charset ='utf-8';
              obj.s.src = 'http://apis.daum.net/search/blog?apikey=' + obj.apikey + '&output=json&callback=obj.pongSearch&q=' + encodeURI(obj.q.value);
              document.getElementsByTagName('head')[0].appendChild(obj.s);
            }
         },
         // �˻� ����� �Ѹ��� �Լ� 
        pongSearch : function(z)
        {
                obj.r.innerHTML = '';
                for (var i = 0; i < z.channel.item.length; i++)
                {
                        var li = document.createElement('li');
                        var a = document.createElement('a');
                        var p = document.createElement('p');
                        a.href = z.channel.item[i].link;
                        a.innerHTML = obj.escapeHtml(z.channel.item[i].title);
                        p.innerHTML =  obj.escapeHtml(z.channel.item[i].description);
                        
                        li.appendChild(a);
                        li.appendChild(p);
                        obj.r.appendChild(li);
                }
        },
        // HTML�±� �� �԰� �ϴ� �Լ�
        escapeHtml : function(str) 
        {
                str = str.replace(/&amp;/g, "&");
                str = str.replace(/&lt;/g, "<");
                str = str.replace(/&gt;/g, ">");
                return str;
        }
};
window.onload = function()
{
  obj.init();
  obj.pingSearch();
};
</script>
</head>
<body>
        <div id="divSearch">
                ���α� �˻� ����
                <input id="q" type="text" value="005930"/>
                <input id="b" type="submit" value="�˻�"/>
        </div>

        <div id="r"></div>
</body>
</html>