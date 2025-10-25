from transformers import AutoTokenizer, AutoModelForSeq2SeqLM
import sys

# Use mT5 multilingual model for Tagalog and other languages
model_name = "google/mt5-small"
tokenizer = AutoTokenizer.from_pretrained(model_name)
model = AutoModelForSeq2SeqLM.from_pretrained(model_name)

def summarize(text):
    input_ids = tokenizer("summarize: " + text, return_tensors="pt").input_ids
    output_ids = model.generate(input_ids, max_length=60)
    summary = tokenizer.decode(output_ids[0], skip_special_tokens=True)
    return summary

if __name__ == "__main__":
    text = sys.argv[1]
    print(summarize(text))