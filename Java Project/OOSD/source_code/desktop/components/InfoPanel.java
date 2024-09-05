/* 
 * Name: Filip Melka & Temur Rustamov
 * Date: April 2024
 */

package components;

import javax.swing.JLabel;
import javax.swing.JPanel;
import utils.Colors;
import utils.Fonts;

public class InfoPanel extends JPanel {

    JLabel label;
    JLabel text;

    public InfoPanel(String label, String text, int width, int height) {

        this.setLayout(null);
        this.setBackground(Colors.BG);

        this.label = new JLabel(label);
        this.label.setBounds(0, 0, width, height / 2);
        this.label.setFont(Fonts.LABEL);
        this.label.setForeground(Colors.LABEL);
        this.add(this.label);

        this.text = new JLabel(text);
        this.text.setBounds(0, height / 2, width, height / 2);
        this.text.setFont(Fonts.AVATAR);
        this.text.setForeground(Colors.TEXT);
        this.add(this.text);

    }

}