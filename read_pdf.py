import PyPDF2
import sys

def read_pdf(file_path):
    try:
        with open(file_path, 'rb') as file:
            reader = PyPDF2.PdfReader(file)
            text = ""
            for page in reader.pages:
                text += page.extract_text() + "\n"
            return text
    except Exception as e:
        return str(e)

if __name__ == "__main__":
    text = read_pdf(r"C:\laragon\www\spk-gout\Noval Lias ramadani-Bab 1-3-Metopen.pdf")
    with open("pdf_content.txt", "w", encoding="utf-8") as f:
        f.write(text)
    print("PDF extraction complete. Check pdf_content.txt.")
