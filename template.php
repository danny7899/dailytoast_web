	
	<div id="content">
    <main>
      <section>
        <h2></h2>
        <article>
          <header>
            <h3></h3>
            <p></p>
			<br/>
          </header>
          <p></p>
          <p></p>
        </article>
      </section>
    </main>

    <aside>
		<h2>This site is under progress</h2>
		<p>The site is still under progress, the pages or subdirectories may not be available yet, e.g. Archives.</p>
		<br/>
	<h2>Please leave a comment</h2>
		<div class="form">
			<form method='post'>
				Name: <input type='text'  style="width: 210px; margin-bottom: 10px;" name='name' id='name' /><br />
	
				Email: <input type='text' style="width: 210px; margin-bottom: 10px;" name='email' id='email' /><br />

				Website: <input type='text' style="width: 210px; margin-bottom: 10px;" name='website' id='website' /><br />

				Comment:<br /><textarea name='comment' style="width: 210px; height: 66px; margin-bottom: 10px;" id='comment'></textarea><br />
	
				<input type='hidden' name='articleid' id='articleid' value='<? echo $_GET["id"]; ?>' />
				<input type='submit' style="width: 210px; margin-bottom: 10px;" value='Submit' />  
			</form>
		</div>
    </aside>
	</div>
	
	<div id="footer">
    <footer>
		<script type="text/javascript">
			tday=new Array("Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday");
			tmonth=new Array("January","February","March","April","May","June","July","August","September","October","November","December");

			function GetClock(){
				var d=new Date();
				var nday=d.getDay(),nmonth=d.getMonth(),ndate=d.getDate(),nyear=d.getYear(),nhour=d.getHours(),nmin=d.getMinutes(),nsec=d.getSeconds(),ap;

				if(nhour==0){ap=" AM";nhour=12;}
				else if(nhour<12){ap=" AM";}
				else if(nhour==12){ap=" PM";}
				else if(nhour>12){ap=" PM";nhour-=12;}

				if(nyear<1000) nyear+=1900;
				if(nmin<=9) nmin="0"+nmin;
				if(nsec<=9) nsec="0"+nsec;

				document.getElementById('clockbox').innerHTML=""+tday[nday]+", "+tmonth[nmonth]+" "+ndate+", "+nyear+" "+nhour+":"+nmin+":"+nsec+ap+"";
			}

			window.onload=function(){
				GetClock();
				setInterval(GetClock,1000);
			}
		</script>
	<div id="clockbox"></div>
	</footer>
	</div>
  </div>
  </body>
</html>