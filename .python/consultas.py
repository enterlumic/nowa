import re
import collections
import tkinter as tk
from tkinter import ttk, messagebox, scrolledtext, filedialog

# Define the regex pattern for the slow query log
log_pattern = re.compile(
    r'# Time: (?P<datetime>\d+ \d+:\d+:\d+)\n# User@Host: (?P<user>.+)\n# Query_time: (?P<query_time>[\d.]+)\s+Lock_time: [\d.]+\s+Rows_sent: \d+\s+Rows_examined: \d+\nuse (?P<database>\w+);\n(?P<query>.+);',
    re.DOTALL
)

def parse_log_entry(entry):
    match = log_pattern.search(entry)
    if match:
        return match.groupdict()
    return None

def analyze_slow_query_log(log_file_path, progress, num_common=5, num_slowest=5):
    try:
        with open(log_file_path, 'r') as log_file:
            slow_queries = []
            log_entry = ''
            total_lines = sum(1 for line in open(log_file_path))
            progress['maximum'] = total_lines

            for i, line in enumerate(log_file):
                if line.startswith('# Time: ') and log_entry:
                    parsed_entry = parse_log_entry(log_entry)
                    if parsed_entry:
                        slow_queries.append(parsed_entry)
                    log_entry = line
                else:
                    log_entry += line

                progress['value'] = i + 1
                root.update_idletasks()
            
            # process the last log entry if present
            if log_entry:
                parsed_entry = parse_log_entry(log_entry)
                if parsed_entry:
                    slow_queries.append(parsed_entry)
    except FileNotFoundError:
        return f"Error: File not found - {log_file_path}"
    except Exception as e:
        return f"Error: {e}"

    if not slow_queries:
        return "No valid slow queries found in the log."

    # Count occurrences of queries
    query_counter = collections.Counter(entry['query'] for entry in slow_queries)

    # Find the slowest queries
    slowest_queries = sorted(slow_queries, key=lambda x: float(x['query_time']), reverse=True)[:num_slowest]

    report = []

    report.append("Most Common Slow Queries:")
    for query, count in query_counter.most_common(num_common):
        report.append(f"{query[:50]}...: {count}")

    report.append("\nSlowest Queries:")
    for query in slowest_queries:
        report.append(f"Query Time: {query['query_time']}s\nDatabase: {query['database']}\nQuery: {query['query']}\n")

    return "\n".join(report)

def load_log_file():
    log_file_path = file_path_entry.get()
    if log_file_path:
        progress['value'] = 0
        report = analyze_slow_query_log(log_file_path, progress)
        report_text.delete(1.0, tk.END)
        report_text.insert(tk.END, report)
    else:
        messagebox.showwarning("Warning", "Please enter a valid file path!")

def save_report():
    report_content = report_text.get(1.0, tk.END)
    if not report_content.strip():
        messagebox.showwarning("Warning", "No report to save!")
        return

    output_file_path = filedialog.asksaveasfilename(title="Save Report", defaultextension=".txt", filetypes=[("Text files", "*.txt"), ("All files", "*.*")])
    if output_file_path:
        try:
            with open(output_file_path, 'w') as f:
                f.write(report_content)
            messagebox.showinfo("Success", f"Report saved to {output_file_path}")
        except Exception as e:
            messagebox.showerror("Error", f"Error writing to file: {e}")

# GUI setup
root = tk.Tk()
root.title("Slow Query Log Analyzer")

frame = tk.Frame(root)
frame.pack(pady=10, padx=10, fill="both", expand=True)

file_path_label = tk.Label(frame, text="Log File Path:")
file_path_label.pack(pady=5)

file_path_entry = tk.Entry(frame, width=80)
file_path_entry.pack(pady=5)

load_button = tk.Button(frame, text="Load Log File", command=load_log_file)
load_button.pack(pady=5)

save_button = tk.Button(frame, text="Save Report", command=save_report)
save_button.pack(pady=5)

progress = ttk.Progressbar(frame, orient=tk.HORIZONTAL, length=400, mode='determinate')
progress.pack(pady=5)

report_text = scrolledtext.ScrolledText(frame, wrap=tk.WORD, width=80, height=20)
report_text.pack(pady=10, padx=10, fill="both", expand=True)

root.mainloop()
