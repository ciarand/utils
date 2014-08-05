test:
	echo 'no tests yet'

doc:
	./vendor/bin/sami.php render doc_conf.php -v

clean:
	rm -rf docs/cache/
