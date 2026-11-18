"""Minimal FastAPI entrypoint for the FORMA RAG service."""

from fastapi import FastAPI

app = FastAPI(title="FORMA RAG Service", version="0.1.0")


@app.get("/health")
def health() -> dict[str, str]:
    """Return service health status."""
    return {"status": "ok", "service": "rag-service"}
