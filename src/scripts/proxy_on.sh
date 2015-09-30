export ftp_proxy=http://proxy.ebiz.verizon.com:80
export http_proxy=http://proxy.ebiz.verizon.com:80
export https_proxy=http://proxy.ebiz.verizon.com:80

curl -v --proxy http://proxy.ebiz.verizon.com:80 --proxy-ntlm --proxy-user "vdsi\\v764675" http://curl.haxx.se
