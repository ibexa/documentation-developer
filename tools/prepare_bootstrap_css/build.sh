curl 'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css' | sed 's/"Courier New",monospace/"Courier New",monospace;/' > bootstrap.min.css
lessc prefix_bootstrap.less bootstrap-iso.css \
  && mv -v bootstrap-iso.css ../../docs/css/ ;
