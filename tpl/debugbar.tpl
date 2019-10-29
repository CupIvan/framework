<style>
	.debugbar     { position: fixed; bottom: 0; left: 0; width: 100%; background: #FAFAFA; box-sizing: border-box;
		border-top: 2px solid #999; font-family: Monospace; max-height: 400px; overflow: auto; }
	.debugbar nav { background: #EEE; }
	.debugbar .noactive { color: #999; }
	.debugbar a { color: #000; font-weight: bold; text-decoration: none; padding: 5px 10px; display: inline-block; }
	.debugbar a:hover { background: #FAFAFA; }
	.debugbar a[href="#close"] { float: right; color: #777; font-size: 24px; font-weight: normal; padding: 0 5px; }
	.debugbar table { width: 100%; border-collapse: collapse; }
	.debugbar table td { border: 1px solid #EEE; padding: 5px 10px; }
	.debugbar table .big td { padding: 0 5px; font-size: 80%; }
	.debugbar table .big tr:hover > td { background: #FFF !important; }
	.debugbar table.t td:nth-child(1) { text-align: right; }
	.debugbar table.t td:nth-child(2) { text-align: center; font-weight: bold; }
	.debugbar table.t td:nth-child(3) { width: 100%; }
</style>
<script>
(function(){
	var info = <?=json_encode(debug::$info)?>;
	var div = document.createElement('div')
	div.className = 'debugbar'

	var i, st = ''

	st += '<a href="#close" title="Закрыть">⊗</a>'

	var n_log = 0, st_log = '', t = info.time_start||0
	for (i in info.log)
	{
		n_log++
		t = info.log[i].time - t
		st_log += '<tr><td>'+Math.round(t*1000)+'ms</td><td>'+info.log[i].type+'</td><td>'+info.log[i].msg+'</td></tr>'
		t = info.log[i].time
	}
	if (st_log) { st_log = '<table class="t">'+st_log+'</table>'; n_log = ' ['+n_log+']' }

	var _n  = function(x) { var i,n=0; for (i in x) n++; return n?' ['+n+']':'' }
	var _st = function(x) {
		var i, t, st='', n = 0
		for (i in x)
		{
			n++;
			t = x[i]
			if (typeof(t) == 'object') t = _st(t)
			st += '<tr><td>'+i+'</td><td>'+t+'</td></tr>'
		}
		return st ? '<table'+(n>10?' class="big"':'')+'>'+st+'</table>' : ''
	}

	var n
	st += '<nav>'
	if (n=n_log) st += '<a href="#log">Messages'+n+'</a>'
	if (n=_n(info.print))   st += '<a href="#print">Print'+n+'</a>'
	if (n_log || n)
	st += ' | '
	if (n=_n(info.request)) st += '<a href="#request">$_REQUEST'+n+'</a>'
	if (n=_n(info.session)) st += '<a href="#session">$_SESSION'+n+'</a>'
	if (n=_n(info.cookies)) st += '<a href="#cookies">$_COOKIE'+n+'</a>'
	if (n=_n(info.server))  st += '<a href="#server">$_SERVER'+n+'</a>'
	st += ' | '
	st += ' <i>'+Math.round((info.time_end-info.time_start)*1000*10)/10+'ms</i>'
	st += ' <i>'+Math.round(info.memory/1024/1024*1000)/1000+'Mb</i>'
	st += '</nav>'

	st += '<section>'
	st += '<div id="log"     style="display: none;">'+st_log+'</div>'
	st += '<div id="print"   style="display: none;">'+_st(info.print)+'</div>'
	st += '<div id="request" style="display: none;">'+_st(info.request)+'</div>'
	st += '<div id="session" style="display: none;">'+_st(info.session)+'</div>'
	st += '<div id="cookies" style="display: none;">'+_st(info.cookies)+'</div>'
	st += '<div id="server"  style="display: none;">'+_st(info.server)+'</div>'
	st += '</section>'

	div.innerHTML = st

	if (!document.body) document.write('<body></body>')
	document.body.appendChild(div)

	div.querySelector('a[href="#close"]').onclick = function(e){
		e.target.parentNode.style.display = 'none'
		return false
	}
	div.querySelector('.debugbar nav').onclick = function(e){
			var i, els = document.querySelectorAll('.debugbar section > *')
			for (i=0; i<els.length; i++) els[i].style.display = 'none'
			var e = document.querySelector('.debugbar section '+e.target.hash)
			if (!e) return false
			e.style.display = 'block'
			return false
	}
})()
</script>
