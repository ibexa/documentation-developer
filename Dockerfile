FROM python:3-slim
COPY ./. /docs/
WORKDIR /docs/
RUN pip install -r requirements.txt
CMD ["mkdocs", "serve", "--dev-addr", "0.0.0.0:8000", "--dirty"]
